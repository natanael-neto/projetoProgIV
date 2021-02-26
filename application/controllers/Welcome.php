<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function index()
	{

		$dados['nome'] = "Natan";
		$dados['idade'] = "21";
		$dados['erro'] = 'No';

		$this->template->load('template', 'start', $dados);
		
	}

	public function telaLogin()
	{
		
		$dados['nome'] = "Anna";
		$dados['idade'] = "18";
		$dados['erro'] = 'No';

		$this->template->load('template', 'telaLogin', $dados);
		
	}
}
