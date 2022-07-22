<?php

use models\bll\ModalidadeBLL;
use models\bll\PlanoBLL;
use models\bll\CategoriaBLL;
use models\bll\ExercicioBLL;
use \models\entidades\Categoria;

defined('BASEPATH') or exit('No direct script access allowed');

class Categorias extends MY_Controller{

    public function index(){

        if ($this->usuarioLogado->getPerfil()->getNome() == 'aluno') {
            redirect("AlunosAgendamento");
        }

        $categoriaBLL = new CategoriaBLL();

        $offset = 0;
        if (!empty($_GET['per_page']) && is_numeric($_GET['per_page'])) {
            $offset = $_GET['per_page'];
        }

        $this->load->library('pagination');
        $data['titulo'] = "Categorias";
        $data['categorias'] = $categoriaBLL->consultarPaginado($offset, $this->pagination->per_page = 15);

        $get = $_GET;
        unset($get['per_page']);

        $config['base_url'] = site_url('Categorias?' . http_build_query($get));
        $config['total_rows'] = $data['categorias']->count();
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);

        $this->template->load('templateInterno', 'categoria/index', $data);
    }

    public function cadastro(){

        $data['titulo'] = "Categorias";
        $this->template->load('templateInterno', 'categoria/cadastro', $data);
    }

    public function editar($id){

        $categoriaBll = new CategoriaBLL();
        $data['categoria'] = $categoriaBll->buscarPorId($id);
        $data['titulo'] = "Categorias";

        $this->template->load('templateInterno', 'categoria/cadastro', $data);
    }

    public function cadastroAction(){
        try{
             $categoriaBll = new CategoriaBLL();

             if($_POST['id']){
                 $categoria = $categoriaBll->buscarPorId($_POST['id']);
             }else{
                 $categoria = new Categoria();
             }

             $retorno = array('erro' => true);

             if(empty($_POST['nome'])){
                throw new Exception("Por favor, digite um nome.");
            }

             if (empty($_POST['descricao'])) {
                throw new Exception("Por favor, digite uma descrição.");
            }

            $categoria->setNome($_POST['nome']);
            $categoria->setDescricao($_POST['descricao']);

            $this->doctrine->em->flush();

            $retorno["erro"] = false;
            $retorno["mensagem"] = "<strong>Sucesso!</strong> Cadastro realizado.";

            die(json_encode($retorno));

        }catch(Exception $e){
            $retorno["mensagem"] = $e->getMessage();
        }

        die(json_encode($retorno));
    }

    public function excluir($id = null){
        try{
            $retorno = array("erro" => true);
            
            if (empty($id)) {
                throw new Exception('ID inválido.');
            }

            $categoriaBll = new CategoriaBLL();
            $exercicioBll = new ExercicioBLL();
            
            $exercicio = $exercicioBll->consultar("m.id = {$id}", null, "JOIN e.categoria m");

            if(count($exercicio) > 0){
                throw new Exception('Esta categoria está cadastrada em um ou mais exercicios. Por favor, cheque os exercicios.');
            }

            $categoria = $categoriaBll->buscarPorId($id);
            $categoriaBll->removerPorId($categoria->getId());

            $this->doctrine->em->flush();

            $retorno["erro"] = false;
            $retorno["mensagem"] = "<strong>Sucesso!</strong> Excluído com sucesso.";

        }catch(Exception $e){
            $retorno["mensagem"] = $e->getMessage();
        }

        die(json_encode($retorno));
    }

}
