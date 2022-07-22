<?php

use models\bll\ProfissionalBLL;
use models\bll\EnderecoBLL;
use models\bll\PerfilBLL;
use models\bll\UsuarioBLL;

defined('BASEPATH') or exit('No direct script access allowed');
class Senhas extends MY_Controller{

    public function index(){

        $data['titulo'] = "ALTERAR SENHA";
        $data['aluno'] = $this->usuarioLogado->getAluno();

        $this->template->load('template', 'senha/index', $data);
    }

    public function alterar(){

        //$body  = json_decode(file_get_contents("php://input"));
        try{
            $retorno = array('erro' => true);
        
            //Senha antiga do usuario
            $senha_antiga = md5($_POST['input-antiga']);
            //Senha que o usuario deseja cadastrar
            $deseja_senha = $_POST['input-senha'];
            $confirma_senha = $_POST['input-confirma'];

            $senha = $this->usuarioLogado->getPassword();
            
            if ($deseja_senha != $confirma_senha){
                throw new Exception('As senhas não Conferem');
            } 
            if ($senha_antiga != $senha){
                throw new Exception('Senha atual não confere');
            }

/*             $this->usuarioLogado->setPassword(md5($deseja_senha));
            $this->doctrine->em->flush(); */
            
            $retorno['erro'] = false; 
            $retorno['mensagem'] = "<strong>Senha alterada com sucesso!</strong>";
        }catch(Exception $e){

            $retorno['mensagem'] = $e->getMessage();
        }

        die(json_encode($retorno));
    }


}