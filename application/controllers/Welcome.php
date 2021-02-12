<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function index()
	{
		$dados['nome'] = "Natan";
		$dados['idade'] = "21";
		$dados['erro'] = 'Opa';

		$this->template->load('template', 'start', $dados);
	}
}
