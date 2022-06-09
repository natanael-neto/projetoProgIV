<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function index()
	{
		$data['exibir'] = false;
		$this->template->load('template', 'inicio/welcome', $data);
	}
}
