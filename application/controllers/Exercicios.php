<?php

use models\bll\ModalidadeBLL;
use models\bll\MedidaBLL;
use models\bll\CategoriaBLL;
use models\bll\ExercicioBLL;
use \models\entidades\Exercicio;

defined('BASEPATH') or exit('No direct script access allowed');

class Exercicios extends MY_Controller{
    
    public function index(){

        if ($this->usuarioLogado->getPerfil()->getNome() == 'aluno') {
            redirect("AlunosAgendamento");
        }

        $exercicioBll = new ExercicioBLL();

        $offset = 0;
        if (!empty($_GET['per_page']) && is_numeric($_GET['per_page'])) {
            $offset = $_GET['per_page'];
        }

        $this->load->library('pagination');
        $data['titulo'] = "Exercicios";
        $data['exercicios'] = $exercicioBll->consultarPaginado($offset, $this->pagination->per_page = 15);

        $get = $_GET;
        unset($get['per_page']);

        $config['base_url'] = site_url('Exercicios?' . http_build_query($get));
        $config['total_rows'] = $data['exercicios']->count();
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);

        $this->template->load('templateInterno', 'exercicio/index', $data);
    }

    public function cadastro(){

        $medidaBll = new MedidaBLL();
        $categoriaBll = new CategoriaBLL();
        $modalidadeBll = new ModalidadeBLL();        

        $data['titulo'] = "Exercicios";
        $data['categorias'] = $categoriaBll->buscarTodos();
        $data['medidas'] = $medidaBll->buscarTodos(); 
        $data['modalidades'] = $modalidadeBll->buscarTodos();

        $this->template->load('templateInterno', 'exercicio/cadastro', $data);
    }

    public function editar($id){

        $exercicioBll = new ExercicioBLL();

        $medidaBll = new MedidaBLL();
        $categoriaBll = new CategoriaBLL();
        $modalidadeBll = new ModalidadeBLL();

        $data['titulo'] = "Exercicios";
        $data['exercicio'] = $exercicioBll->buscarPorId($id);
        $data['modalidades'] = $modalidadeBll->buscarTodos();
        $data['categorias'] = $categoriaBll->buscarTodos();
        $data['medidas'] = $medidaBll->buscarTodos();

        $this->template->load('templateInterno', 'exercicio/cadastro', $data);
    }

    public function cadastroAction(){

        try{
            $exercicioBll = new ExercicioBLL();

            if($_POST['id']){
                $exercicio = $exercicioBll->buscarPorId($_POST['id']);
            }else{
                $exercicio = new Exercicio();
            }

            $retorno = array('erro' => true);

            //Validações

            if(empty($_POST['nome'])){
                throw new Exception("Por favor, digite um nome.");
            }
            if(empty($_POST['categoria'])){
                throw new Exception("Por favor, selecione uma categoria.");
            }
            if(empty($_POST['modalidades'])){
                throw new Exception("Por favor, selecione uma ou mais modalidades.");
            }
            if(empty($_POST['medida'])){
                throw new Exception("Por favor, selecione uma medida.");
            }

            $medidaBll = new MedidaBLL();
            $categoriaBll = new CategoriaBLL();
            $modalidadeBll = new ModalidadeBLL();

            $categoria = $categoriaBll->buscarPorId($_POST['categoria']);
            //$modalidade = $modalidadeBll->buscarPorId($_POST['modalidade']);
            $medida = $medidaBll->buscarPorId($_POST['medida']);

            $exercicio->setNome($_POST['nome']);
            $exercicio->setCategoria($categoria);
            //$exercicio->setModalidades($modalidade);
            $exercicio->setMedida($medida);

            $exercicio->getModalidades()->clear();

            foreach($_POST['modalidades'] as $modalidade_id){
                /** @var Modalidade $modalidade*/
                $modalidade = $modalidadeBll->buscarPorId($modalidade_id);

                $modalidade->getExercicios()->clear();
                $modalidade->getExercicios()->add($exercicio);

                $exercicio->getModalidades()->add($modalidade);
            }

            $this->doctrine->em->flush();

            $retorno["erro"] = false;
            $retorno["mensagem"] = "<strong>Sucesso!</strong> Cadastro realizado.";
        }catch(Exception $e){
            $retorno["mensagem"] = $e->getMessage();
        }
        die(json_encode($retorno));
    }

    public function excluir($id = null){

        try{
            $retorno = array('erro' => true);

            if(empty($id)){
                throw new Exception('ID inválido.');
            }

            $modalidadeBll = new ModalidadeBLL();
            $exercicioBll = new ExercicioBLL();

            //ex seria uma abreviação de exercicios qua faz referência à exercicios de models\entidades\Modalidade: protected $exercicios
            $modalidade = $modalidadeBll->consultar("ex.id = {$id}", null, "JOIN e.exercicios ex");
            
            $exercicio = $exercicioBll->buscarPorId($id);
            $exercicio->getModalidades()->clear();
            $exercicioBll->removerPorId($exercicio);

            $this->doctrine->em->flush();

            $retorno["erro"] = false;
            $retorno["mensagem"] = "<strong>Sucesso!</strong> Excluído com sucesso.";
        }catch(Exception $e){
            $retorno["mensagem"] = $e->getMessage();
        }
        die(json_encode($retorno));
    }


}