<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AlunosAgendamento extends MY_Controller
{
	public function index()
	{
		$alunoBLL = new \models\bll\AlunoBLL();

		$cpf = $this->usuarioLogado->getLogin();
		$aluno = $alunoBLL->buscarUmPor(array("cpf" => $cpf));
		
		$data['titulo'] = "Agendamento";
		$data['aluno'] = $aluno;

		$this->template->load('template', 'inicio/inicioAluno', $data);
	}
}
