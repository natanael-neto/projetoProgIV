<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inicio extends MY_Controller
{
	public function index()
	{
		$this->template->load('template', 'inicio');
	}
}
