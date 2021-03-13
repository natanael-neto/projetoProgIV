<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Professores extends CI_Controller
{
    public function index()
    {
        $professorBLL = new \models\bll\ProfessorBLL();
        
        $data['titulo'] = "Professores";
        $data['professores'] = $professorBLL->buscarTodos();

        $this->template->load('templateInterno', 'professor/index', $data);
    }

    public function cadastro()
    {
        $data['titulo'] = "Professores";
        $this->template->load('templateInterno', 'professor/cadastro', $data);
    }
}
