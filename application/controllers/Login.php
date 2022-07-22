<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller{
    public function index()
    {
        if (isset($_SESSION['logado']) && $_SESSION['logado'] == 1) {
            if (perfilUsuario($_SESSION['login']) == 'aluno'){
                redirect('AlunosAgendamento');
            } else {
                redirect('Inicio');
            }
        }

        $data['titulo'] = "Login";
        $this->template->load('template', 'login/login', $data);
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
                    redirect('AlunosAgendamento');
                } else {
                    redirect('Inicio');
                }
            }
        } catch (Exception $e) {
            die("Ocorreu um erro.");
        }
    }

    public function deslogar()
    {
        $this->session->sess_destroy();
        redirect('Welcome');
    }

    public function esqueci(){ 

        $data['titulo'] = "Esqueceu sua senha?";
        $this->template->load('template', 'senha/esqueci', $data);
    }

    public function esqueciBuscar(){
        try{
            $retorno = array('erro' => true);
            
            $cpf = $_POST['input-cpf'];

            $usuarioBLL = new \models\bll\UsuarioBLL();

            $usuario = $usuarioBLL->buscarUmPor(array("login" => "{$_POST['input-cpf']}"));

            if($usuario != null){

                $requisicao = new \models\entidades\Requisicao;
                $email =  $usuario->getEmail();

                $retorno["erro"] = false;
                $retorno["email"] = $email;
                $hash = uniqid('Sis');
                $link = "http://local.site:96/Login/esqueciGet?request=" . $hash;

                //Salvo a requisição de recuperar senha no banco
                $requisicao->setRequisicao($hash);
                $requisicao->setUsuario($usuario);
                $this->doctrine->em->flush();

                $mensagem = '
                <style>
                body{ text-align: center;}
                </style>
                <body>
                    <a href="'. $link .'">'. $link .'<a>
                </body>';

                //Envio um e-mail HTML com link para recuperar a senha 
                $this->load->library('email');
                $config['mailtype'] = 'html';
                $this->email->initialize($config);

                $this->email->from("sisctrlgym@email.com", "Academia SisCtrl");
                $this->email->to($email);
                $this->email->subject('Clique para recuperar sua senha');
                $this->email->message($mensagem);
                $this->email->send();

            } else {
                $retorno["erro"] = true;
                $retorno["mensagem"] = "Este cpf não consta na nossa base de dados!!";
            }

        }catch(Exception $e){
            $retorno["mensagem"] = $e->getMessage();
        }
        
        die(json_encode($retorno));
    }

    public function esqueciGet(){

            //$usuarioBLL = new \models\bll\UsuarioBLL();
            $requisicaoBLL = new \models\bll\RequisicaoBLL();

            $requisicao = $requisicaoBLL->buscarUmPor(array("requisicao" => "{$_GET['request']}"));
            $ativo = $requisicao && $requisicao->isActive();
            $data['titulo'] = 'Recuperar Senha';

            if(!is_null($requisicao) && $ativo == 1){
                //Pego a data atual e a data em que foi registrada a requisição e verifico a diferença de horas entre tais. 
                $data_atual = new DateTime();
                //$data_atual->add(new DateInterval('P2D'));
                $data_registro = $requisicao->getDataRegistro();
                $diferenca = date_diff($data_registro, $data_atual);
                $total_horas = $diferenca->format('%d');
                
                if($total_horas != 0){
                    //Verifico se ja se passaram 24 horas desde o envio de e-mail, caso tenha passado eu digo que essa requisiçõa não está mais ativa
                    $requisicao->setActive(false);
                    $this->doctrine->em->flush();

                    $data['user'] = null;
                    $this->template->load('template', 'senha/recuperar', $data); 
                } 

                $_SESSION['request'] = $requisicao->getRequisicao();
                $data['user'] = $requisicao->getUsuario();
                $this->template->load('template', 'senha/recuperar', $data);

            }else{

                $data['user'] = null;
                $this->template->load('template', 'senha/recuperar', $data);
            }
    }

    public function esqueciAction(){
        try{
            $retorno = array('erro' => true);
            $requisicaoBLL = new \models\bll\RequisicaoBLL();

            $deseja_senha = $_POST['input-senha'];
            $confirma_senha = $_POST['input-confirma'];

            $requisicao = $requisicaoBLL->buscarUmPor(array("requisicao" => "{$_SESSION['request']}"));
            $user = $requisicao->getUsuario();

             if ($deseja_senha != $confirma_senha){
                throw new Exception('As senhas não Conferem');
            }

            $user->setPassword(md5($deseja_senha));
            $requisicao->setActive(false);

            $this->doctrine->em->flush();
            unset($_SESSION['request']);

            $retorno['erro'] = false; 
            $retorno['mensagem'] = "<strong>Senha alterada com sucesso!</strong>";
        }catch(Exception $e){
            $retorno["mensagem"] = $e->getMessage();
        }
        
        die(json_encode($retorno));
    }

}

