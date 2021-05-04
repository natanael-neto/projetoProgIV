<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AlunosAgendamento extends MY_Controller
{
	public function index()
	{
		$alunoBLL = new \models\bll\AlunoBLL();
		$aulaBLL = new \models\bll\AulaBLL();

		$cpf = $this->usuarioLogado->getLogin();
		
		$aluno = $alunoBLL->buscarUmPor(array("cpf" => $cpf));
		
		$modalidades = "";
		$contador = 1;

		foreach($aluno->getPlano()->getModalidades() as $modalidade){
			if(count($aluno->getPlano()->getModalidades()) != $contador){
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

		$this->template->load('template', 'inicio/inicioAluno', $data);
	}
}
