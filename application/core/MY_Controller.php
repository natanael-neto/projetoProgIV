<?php

use models\entidades\Usuario;


if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Usuario $usuarioLogado
 */
class MY_Controller extends CI_Controller
{
    public $data = array();
    public $usuarioLogado = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->checarAutenticacao();

        if (isset($_SESSION['logado']) && $_SESSION['logado'] == 1) {
            $usuarioBLL = new \models\bll\UsuarioBLL();
            $this->usuarioLogado = $usuarioBLL->buscarUmPor(array('login' => $_SESSION['login']));
            $this->data["usuarioLogado"] = $this->usuarioLogado;
        }
    }

    protected function checarAutenticacao()
    {
        if (!(isset($_SESSION['logado']) && $_SESSION['logado'] == 1)) {
            redirect('Login/#');
            exit;
        }
    }
}
