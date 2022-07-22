<?php

use models\bll\ExercicioBLL;
use models\bll\AgendamentoBLL;
use models\bll\MedidaBLL;
use \models\entidades\Medida;

defined('BASEPATH') or exit('No direct script access allowed');

class Medidas extends MY_Controller{

    public function index(){

        if ($this->usuarioLogado->getPerfil()->getNome() == 'aluno') {
            redirect("AlunosAgendamento");
        }

        $MedidaBLL = new MedidaBLL;

        $offset = 0;
        if (!empty($_GET['per_page']) && is_numeric($_GET['per_page'])) {
            $offset = $_GET['per_page'];
        }

        $this->load->library('pagination');
        $data['titulo'] = "Medidas";
        $data['medidas'] = $MedidaBLL->consultarPaginado($offset, $this->pagination->per_page = 15);

        $get = $_GET;
        unset($get['per_page']);

        $config['base_url'] = site_url('Medidas?' . http_build_query($get));
        $config['total_rows'] = $data['medidas']->count();
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);

        $this->template->load('templateInterno', 'medida/index', $data);

    }

    public function cadastro(){

        $data['titulo'] = "Medidas";
        $this->template->load('templateInterno', 'medida/cadastro', $data);

    }

    public function editar($id) {
        
        $MedidaBLL = new MedidaBLL;

        $data['titulos'] = 'Medidas';
        $data['medida'] = $MedidaBLL->buscarPorId($id);
        $this->template->load('templateInterno', 'medida/cadastro', $data);

    }
    public function cadastroAction(){

        try{
            $medidaBll = new MedidaBLL();
       
            if($_POST['id']){
                $medida = $medidaBll->buscarPorId($_POST['id']);
            }else{
                $medida = new Medida(); 
            }

            $retorno = array('erro' => true);

            if (empty($_POST['nome'])) {
                throw new Exception("Por favor, digite um nome.");
            }

            $medida->setNome($_POST['nome']);

            $this->doctrine->em->flush();

            $retorno['erro'] = false;
            $retorno['mensagem'] = "<strong>Sucesso!</strong> Cadastro realizado.";
        }catch(Exception $e){
            $retorno["mensagem"] = $e->getMessage();
        }

        die(json_encode($retorno));
    }

    public function excluir($id = null){
        try{
            $retorno = array('erro' => true);

            if (empty($id)) {
                throw new Exception('ID inválido.');
            }

             $MedidaBLL = new MedidaBLL();
             $exercicioBll = new ExercicioBLL();

             $exercicio = $exercicioBll->consultar("m.id = {$id}", null, "JOIN e.medida m");

             if(count($exercicio) > 0){
                throw new Exception('Esta medida está cadastrada em um ou mais exercicios. Por favor, cheque os exercicios.');
            }

             $medida = $MedidaBLL->buscarPorId($id);
             $MedidaBLL->removerPorId($medida->getId());

             $this->doctrine->em->flush();

             $retorno["erro"] = false;
             $retorno["mensagem"] = "<strong>Sucesso!</strong> Excluído com sucesso.";

        }catch(Exception $e){
            $retorno["mensagem"] = $e->getMessage();
        }

        die(json_encode($retorno));

    }

}