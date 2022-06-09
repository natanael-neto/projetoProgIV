<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inicio extends MY_Controller
{
	public function index(){
		
		if ($this->usuarioLogado->getPerfil()->getNome() == 'aluno') {
			redirect("AlunosAgendamento");
		}
		
		
		$this->template->load('template', 'inicio/inicio');
	}
}
