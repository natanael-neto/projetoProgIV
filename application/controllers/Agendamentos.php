<?php

use models\bll\AgendamentoBLL;
use models\bll\AlunoBLL;
use models\bll\AulaBLL;
use \models\entidades\Agendamento;

defined('BASEPATH') or exit('No direct script access allowed');

class Agendamentos extends MY_Controller
{
    public function index()
    {
        if ($this->usuarioLogado->getPerfil()->getNome() == 'aluno') {
            redirect("AlunosAgendamento");
        }

        $agendamentoBLL = new AgendamentoBLL();

        $offset = 0;
        if (!empty($_GET['per_page']) && is_numeric($_GET['per_page'])) {
            $offset = $_GET['per_page'];
        }

        $this->load->library('pagination');
        $data['titulo'] = "Agendamentos";
        $data['agendamentos'] = $agendamentoBLL->consultarPaginado($offset, $this->pagination->per_page = 15);

        $get = $_GET;
        unset($get['per_page']);

        $config['base_url'] = site_url('Agendamentos?' . http_build_query($get));
        $config['total_rows'] = $data['agendamentos']->count();
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);

        $this->template->load('templateInterno', 'agendamento/index', $data);
    }

    public function cadastro()
    {
        $aulaBLL = new AulaBLL();
        $alunoBLL = new AlunoBLL();

        $data['titulo'] = "Agendamentos";
        $data['aulas'] = $aulaBLL->buscarTodos();
        $data['alunos'] = $alunoBLL->buscarTodos();

        $this->template->load('templateInterno', 'agendamento/cadastro', $data);
    }

    public function editar($id)
    {
        $agendamentoBLL = new AgendamentoBLL();
        $aulaBLL = new AulaBLL();
        $alunoBLL = new AlunoBLL();

        $data['titulo'] = "Agendamentos";
        $data['agendamento'] = $agendamentoBLL->buscarPorId($id);
        $data['aulas'] = $aulaBLL->buscarTodos();
        $data['alunos'] = $alunoBLL->buscarTodos();

        $this->template->load('templateInterno', 'agendamento/cadastro', $data);
    }

    public function cadastroAction()
    {
        try {
            if ($_POST['id']) {
                $agendamentoBLL = new AgendamentoBLL();
                $agendamento = $agendamentoBLL->buscarPorId($_POST['id']);
            } else {
                $agendamento = new Agendamento();
            }

            $retorno = array('erro' => true);
            $aulaBLL = new AulaBLL();
            $alunoBLL = new AlunoBLL();
            $agendamentoBLL = new AgendamentoBLL();

            $data = new DateTime('today');

            if ($_POST['data'] == 'amanha') {
                $data->add(new DateInterval('P1D'));
            }

            $aula = $aulaBLL->buscarPorId($_POST['aula']);
            $aluno = $alunoBLL->buscarPorId($_POST['aluno']);

            // Validações
            $agendamentoIgual = $agendamentoBLL->consultar("al.id = {$_POST['aluno']} AND a.id = {$_POST['aula']}", null, "JOIN e.aluno al JOIN e.aula a");
            $vagasPreenchidas = count($agendamentoBLL->consultar("a.id = {$_POST['aula']} AND e.dataAgendamento = {$data->format('Y-m-d')}", null, "JOIN e.aula a"));

            if (count($agendamentoIgual) > 0 && !$_POST['id']) {
                throw new Exception("Já existe um agendamento com esse aluno e com essa aula cadastrado.");
            }

            if ($vagasPreenchidas >= $aula->getCapacidade()) {
                throw new Exception("A aula já está lotada, por favor, selecione outra.");
            }

            $agendamento->setAluno($aluno);
            $agendamento->setAula($aula);
            $agendamento->setDataAgendamento($data);
            $agendamento->setObservacao($_POST['observacao']);

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

            $agendamentoBLL = new AgendamentoBLL();

            $agendamentoBLL->removerPorId($agendamentoBLL->buscarPorId($id));

            $this->doctrine->em->flush();

            $retorno["erro"] = false;
            $retorno["mensagem"] = "<strong>Sucesso!</strong> Excluído com sucesso.";
        } catch (Exception $e) {
            $retorno["mensagem"] = $e->getMessage();
        }

        die(json_encode($retorno));
    }
}
