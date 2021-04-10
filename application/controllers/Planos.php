<?php

use models\bll\ModalidadeBLL;
use models\bll\PlanoBLL;
use models\entidades\Plano;

defined('BASEPATH') or exit('No direct script access allowed');

class Planos extends MY_Controller
{
    public function index()
    {
        if ($this->usuarioLogado->getPerfil()->getNome() == 'aluno') {
            redirect("AlunosAgendamento");
        }

        $planoBLL = new PlanoBLL();

        $offset = 0;
        if (!empty($_GET['per_page']) && is_numeric($_GET['per_page'])) {
            $offset = $_GET['per_page'];
        }

        $this->load->library('pagination');
        $data['titulo'] = "Planos";
        $data['planos'] = $planoBLL->consultarPaginado($offset, $this->pagination->per_page = 15);

        $get = $_GET;
        unset($get['per_page']);

        $config['base_url'] = site_url('Planos?' . http_build_query($get));
        $config['total_rows'] = $data['planos']->count();
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);

        $this->template->load('templateInterno', 'plano/index', $data);
    }

    public function cadastro()
    {
        $modalidadeBLL = new ModalidadeBLL();

        $data['titulo'] = "Planos";
        $data['modalidades'] = $modalidadeBLL->buscarTodos();
        $this->template->load('templateInterno', 'plano/cadastro', $data);
    }

    public function editar($id)
    {
        $planoBLL = new PlanoBLL();
        $modalidadeBLL = new ModalidadeBLL();

        $data['plano'] = $planoBLL->buscarPorId($id);
        $data['titulo'] = "Planos";
        $data['modalidades'] = $modalidadeBLL->buscarTodos();
        $this->template->load('templateInterno', 'plano/cadastro', $data);
    }

    public function cadastroAction()
    {        
        try {
            if ($_POST['id']) {
                $planoBLL = new PlanoBLL();
                $plano = $planoBLL->buscarPorId($_POST['id']);
            } else {
                $plano = new Plano();
            }

            $retorno = array('erro' => true);

            // Validações
            if (empty($_POST['nome'])) {
                throw new Exception("Por favor, digite um nome.");
            }

            if (empty($_POST['valor'])) {
                throw new Exception("Por favor, digite um valor.");
            }

            if (empty($_POST['modalidades'])) {
                throw new Exception("Por favor, selecione uma ou mais modalidades.");
            }

            if (empty($_POST['descricao'])) {
                throw new Exception("Por favor, digite uma descrição.");
            }

            $plano->setNome($_POST['nome']);
            $plano->setValor(removerMaskmoney($_POST['valor']));
            $plano->setDescricao($_POST['descricao']);

            $modalidadeBLL = new ModalidadeBLL();
            
            $plano->getModalidades()->clear();
            
            foreach ($_POST['modalidades'] as $modalidade_id) {
                /** @var Modalidade $modalidade*/
                $modalidade = $modalidadeBLL->buscarPorId($modalidade_id);
                
                $modalidade->getPlanos()->clear();
                $modalidade->getPlanos()->add($plano);
                
                $plano->getModalidades()->add($modalidade);
            }

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

            $planoBLL = new PlanoBLL();           
            $planoBLL->removerPorId($id);

            $this->doctrine->em->flush();

            $retorno["erro"] = false;
            $retorno["mensagem"] = "<strong>Sucesso!</strong> Excluído com sucesso.";
        } catch (Exception $e) {
            $retorno["mensagem"] = $e->getMessage();
        }

        die(json_encode($retorno));
    }
}
