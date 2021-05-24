<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AlunosAgendamento extends MY_Controller
{
	public function index()
	{
		$this->template->load('template', 'inicio/inicioAluno');
	}

	public function agendar()
	{
		$alunoBLL = new \models\bll\AlunoBLL();
		$aulaBLL = new \models\bll\AulaBLL();

		$cpf = $this->usuarioLogado->getLogin();

		$aluno = $alunoBLL->buscarUmPor(array("cpf" => $cpf));

		$modalidades = "";
		$contador = 1;

		foreach ($aluno->getPlano()->getModalidades() as $modalidade) {
			if (count($aluno->getPlano()->getModalidades()) != $contador) {
				$modalidades .= "'" . $modalidade->getNome() . "'" . ", ";
			} else {
				$modalidades .= "'" . $modalidade->getNome() . "'";
			}
			$contador++;
		}

		$aulas = $aulaBLL->consultar("m.nome IN ({$modalidades})", null, "JOIN e.modalidade m");
		$data['titulo'] = "Agendamento";
		$data['aulas'] = $aulas;
		$data['aluno'] = $aluno;

		$this->template->load('template', 'agendamento/cadastroPorAluno', $data);
	}

	public function agendamentos($id)
	{
		$agendamentoBLL = new models\bll\AgendamentoBLL();

		$offset = 0;
		if (!empty($_GET['per_page']) && is_numeric($_GET['per_page'])) {
			$offset = $_GET['per_page'];
		}

		$this->load->library('pagination');
		$data['titulo'] = "Agendamentos";
		$data['agendamentos'] = $agendamentoBLL->consultarPaginado($offset, $this->pagination->per_page = 15, "e.aluno = {$id}");

		$get = $_GET;
		unset($get['per_page']);

		$config['base_url'] = site_url('Agendamentos?' . http_build_query($get));
		$config['total_rows'] = $data['agendamentos']->count();
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);

		$this->template->load('template', 'agendamento/index', $data);
	}
}
