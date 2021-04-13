<?php

use models\bll\AgendamentoBLL;
use models\bll\ModalidadeBLL;
use models\bll\ProfessorBLL;
use models\bll\AulaBLL;
use \models\entidades\Aula;

defined('BASEPATH') or exit('No direct script access allowed');

class Aulas extends MY_Controller
{
    public function index()
    {
        if ($this->usuarioLogado->getPerfil()->getNome() == 'aluno') {
            redirect("AlunosAgendamento");
        }

        $aulaBLL = new AulaBLL();

        $offset = 0;
        if (!empty($_GET['per_page']) && is_numeric($_GET['per_page'])) {
            $offset = $_GET['per_page'];
        }

        $this->load->library('pagination');
        $data['titulo'] = "Aulas";
        $data['aulas'] = $aulaBLL->consultarPaginado($offset, $this->pagination->per_page = 15);

        $get = $_GET;
        unset($get['per_page']);

        $config['base_url'] = site_url('Aulas?' . http_build_query($get));
        $config['total_rows'] = $data['aulas']->count();
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);

        $this->template->load('templateInterno', 'aula/index', $data);
    }

    public function cadastro()
    {
        $professorBLL = new ProfessorBLL();
        $modalidadeBLL = new ModalidadeBLL();

        $data['titulo'] = "Aulas";
        $data['professores'] = $professorBLL->buscarTodos();
        $data['modalidades'] = $modalidadeBLL->buscarTodos();

        $this->template->load('templateInterno', 'aula/cadastro', $data);
    }

    public function editar($id)
    {
        $aulaBLL = new AulaBLL();
        $professorBLL = new ProfessorBLL();
        $modalidadeBLL = new ModalidadeBLL();

        $data['titulo'] = "Aulas";
        $data['aula'] = $aulaBLL->buscarPorId($id);
        $data['professores'] = $professorBLL->buscarTodos();
        $data['modalidades'] = $modalidadeBLL->buscarTodos();

        $this->template->load('templateInterno', 'aula/cadastro', $data);
    }

    public function cadastroAction()
    {
        try {
            if ($_POST['id']) {
                $aulaBLL = new AulaBLL();
                $aula = $aulaBLL->buscarPorId($_POST['id']);
            } else {
                $aula = new Aula();
            }

            $retorno = array('erro' => true);
            $professorBLL = new ProfessorBLL();
            $modalidadeBLL = new ModalidadeBLL();

            // Validações
            if (empty($_POST['horario'])) {
                throw new Exception("Por favor, digite um horário.");
            }

            if (empty($_POST['capacidade']) || !is_numeric($_POST['capacidade']) || (int) $_POST['capacidade'] <= 0) {
                throw new Exception("Por favor, digite uma capacidade válida.");
            }

            $horario = explode(":", $_POST['horario']);
            
            if ((int) $horario[0] < 0 || (int) $horario[0] > 23) {
                throw new Exception("As horas devem ser entre 00h e 23h.");
            }

            if ((int) $horario[1] < 0 || (int) $horario[1] > 59) {
                throw new Exception("As minutos devem ser entre 00m e 59m.");
            }

            $professor = $professorBLL->buscarPorId($_POST['professor']);
            $modalidade = $modalidadeBLL->buscarPorId($_POST['modalidade']);

            $dataBase = new DateTime();
            $dataBase = $dataBase->format('Y-m-d') . $_POST['horario'] . ":00";

            $horarioFinal = DateTime::createFromFormat("Y-m-d H:i:s", $dataBase);

            $aula->setProfessor($professor);
            $aula->setModalidade($modalidade);
            $aula->setHorario($horarioFinal);
            $aula->setCapacidade($_POST['capacidade']);

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
            $aulaBLL = new AulaBLL();

            $agendamentos = $agendamentoBLL->consultar("a.id = {$id}", null, "JOIN e.aula a");

            if (count($agendamentos) > 0) {
                throw new Exception('Esta aula está cadastrada em uma ou mais agendamentos. Por favor, cheque os agendamentos.');
            }

            $aulaBLL->removerPorId($aulaBLL->buscarPorId($id));

            $this->doctrine->em->flush();

            $retorno["erro"] = false;
            $retorno["mensagem"] = "<strong>Sucesso!</strong> Excluído com sucesso.";
        } catch (Exception $e) {
            $retorno["mensagem"] = $e->getMessage();
        }

        die(json_encode($retorno));
    }
}
