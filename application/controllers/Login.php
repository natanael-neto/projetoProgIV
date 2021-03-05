<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends CI_Controller
{
    public function index()
    {
        if (isset($_SESSION['logado']) && $_SESSION['logado'] == 1) {
            if (perfilUsuario($_SESSION['login']) == 'aluno'){
                redirect('Aluno');
            } else {
                redirect('Inicio');
            }
        }

        $data['titulo'] = "Login";
        $this->template->load('template', 'login', $data);
    }

    function mostrarMensagem($message)
    {
        $this->session->set_flashdata('message', $message);
        redirect('/Login/');
    }

    public function logar()
    {
        try {
            $usuarioBLL = new \models\bll\UsuarioBLL();
            $login = $_POST['login'];
            $senha = $_POST['senha'];

            if (empty($login) || empty($senha)) {
                $this->mostrarMensagem("Os campos não foram preenchidos corretamente.");
            }

            $usuario = $usuarioBLL->buscarUmPor(array("login" => "{$login}"));

            if (empty($usuario) || $usuario->getPassword() !== md5($senha)) {
                $this->mostrarMensagem("Usuário e/ou senhas incorretos.");
            } else {
                $_SESSION['logado'] = 1;
                $_SESSION['login'] = $usuario->getLogin();
                if ($usuario->getPerfil()->getNome() == "aluno"){
                    redirect('Aluno');
                } else {
                    redirect('Inicio');
                }
            }
        } catch (\Exception $e) {
            die("Ocorreu um erro.");
        }
    }

    public function deslogar()
    {
        $this->session->sess_destroy();
        redirect('Welcome');
    }
}
