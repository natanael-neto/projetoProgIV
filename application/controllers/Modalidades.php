<?php

use models\bll\ExercicioBLL;
use models\bll\ModalidadeBLL;
use models\bll\PlanoBLL;
use models\bll\AulaBLL;
use \models\entidades\Modalidade;

defined('BASEPATH') or exit('No direct script access allowed');

class Modalidades extends MY_Controller
{
    public function index()
    {
        if ($this->usuarioLogado->getPerfil()->getNome() == 'aluno') {
            redirect("AlunosAgendamento");
        }

        $modalidadeBLL = new ModalidadeBLL();

        $offset = 0;
        if (!empty($_GET['per_page']) && is_numeric($_GET['per_page'])) {
            $offset = $_GET['per_page'];
        }

        $this->load->library('pagination');
        $data['titulo'] = "Modalidades";
        $data['modalidades'] = $modalidadeBLL->consultarPaginado($offset, $this->pagination->per_page = 15);

        $get = $_GET;
        unset($get['per_page']);

        $config['base_url'] = site_url('Modalidades?' . http_build_query($get));
        $config['total_rows'] = $data['modalidades']->count();
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);

        $this->template->load('templateInterno', 'modalidade/index', $data);
    }

    public function cadastro()
    {
        $data['titulo'] = "Modalidades";
        $this->template->load('templateInterno', 'modalidade/cadastro', $data);
    }

    public function editar($id)
    {
        $modalidadeBLL = new ModalidadeBLL();
        $exercicioBLL = new ExercicioBLL();

        $data['modalidade'] = $modalidadeBLL->buscarPorId($id);
        $data['exercicio'] = $exercicioBLL->buscarPorId($id);
        $data['titulo'] = "Modalidades";
        $this->template->load('templateInterno', 'modalidade/cadastro', $data);
    }

    public function cadastroAction()
    {
        try {
            if ($_POST['id']) {
                $modalidadeBLL = new ModalidadeBLL();
                $modalidade = $modalidadeBLL->buscarPorId($_POST['id']);
            } else {
                $modalidade = new Modalidade();
            }

            $retorno = array('erro' => true);

            // Validações
            if (empty($_POST['nome'])) {
                throw new Exception("Por favor, digite um nome.");
            }

            if (empty($_POST['descricao'])) {
                throw new Exception("Por favor, digite uma descrição.");
            }

            $modalidade->setNome($_POST['nome']);
            $modalidade->setDescricao($_POST['descricao']);

            $this->doctrine->em->flush();

            $retorno["erro"] = false;
            $retorno["mensagem"] = "<strong>Sucesso!</strong> Cadastro realizado.";
        } catch (Exception $e) {
            $retorno["mensagem"] = $e->getMessage();
        }

        die(json_encode($retorno));
    }

    public function excluir($id = null)
    {
        try {
            $retorno = array('erro' => true);

            if (empty($id)) {
                throw new Exception('ID inválido.');
            }
            $modalidadeBLL = new ModalidadeBLL();
            $aulaBLL = new AulaBLL();
            $planoBLL = new PlanoBLL();
            $exercicioBLL = new ExercicioBLL();

            $aulas = $aulaBLL->consultar("m.id = {$id}", null, "JOIN e.modalidade m");
            $planos = $planoBLL->consultar("m.id = {$id}", null, "JOIN e.modalidades m");
            $exercicios = $exercicioBLL->consultar("m.id = {$id}", null, "JOIN e.modalidades m");

            if (count($aulas) > 0) {
                throw new Exception('Esta modalidade está cadastrada em uma ou mais aulas. Por favor, cheque as aulas.');
            }

            if (count($planos) > 0) {
                throw new Exception('Esta modalidade está cadastrada em um ou mais planos. Por favor, cheque os planos.');
            }
            
/*             if(count($exercicios) > 0){
                throw new Exception('Esta modalidade está cadastrada em um ou mais exercicios. Por favor, cheque os exercicios.'); 
            } */
            //Busco a modalidade por ID e em seguida pego essa modalidade e dou um get nos Exercicios em seguida dou o clear
            $modalidade = $modalidadeBLL->buscarPorId($id);
            $modalidade->getExercicios()->clear();
            $modalidadeBLL->removerPorId($modalidade->getId());

            $this->doctrine->em->flush();

            $retorno["erro"] = false;
            $retorno["mensagem"] = "<strong>Sucesso!</strong> Excluído com sucesso.";
        } catch (Exception $e) {
            $retorno["mensagem"] = $e->getMessage();
        }

        die(json_encode($retorno));
    }
}
