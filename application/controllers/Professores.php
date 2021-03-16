<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Professores extends MY_Controller
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

    public function cadastroAction()
    {
        try {

            $retorno = array('erro' => true);
            
            // Validações
            if (empty($_POST['nome'])) {
                throw new Exception("Por favor, digite um nome.");
            }

            if (empty($_POST['cpf']) || !validaCpf($_POST['cpf'])) {
                throw new Exception("Por favor, digite um CPF válido.");
            }

            if (empty($_POST['email']) || !validaEmail($_POST['email'])) {
                throw new Exception("Por favor, digite um e-mail válido.");
            }

            if (empty($_POST['telefone'])) {
                throw new Exception("Por favor, digite um telefone.");
            }

            if (empty($_POST['dataNascimento']) || !validaDataNascimento($_POST['dataNascimento'])) {
                throw new Exception("Por favor, digite uma data de nascimento válida.");
            }

            if (empty($_POST['cref'])) {
                throw new Exception("Por favor, digite um CREF.");
            }

            if (empty($_POST['logradouro'])) {
                throw new Exception("Por favor, digite um logradouro.");
            }

            if (empty($_POST['numero'])) {
                throw new Exception("Por favor, digite o número do seu endereço.");
            }

            if (empty($_POST['cidade'])) {
                throw new Exception("Por favor, digite uma cidade.");
            }

            if (empty($_POST['estado'])) {
                throw new Exception("Por favor, digite um estado.");
            }

            if (empty($_POST['pais'])) {
                throw new Exception("Por favor, digite um país.");
            }

            if (empty($_POST['bairro'])) {
                throw new Exception("Por favor, digite um bairro.");
            }

            if (empty($_POST['complemento'])) {
                throw new Exception("Por favor, digite um complemento.");
            }

            if (empty($_POST['pontoReferencia'])) {
                throw new Exception("Por favor, digite um ponto de referência.");
            }

            if (empty($_POST['cep']) || !is_numeric($_POST['cep'])) {
                throw new Exception("Por favor, digite um CEP válido.");
            }

            $professor = new \models\entidades\Professor();
            $endereco = new \models\entidades\Endereco();

            $endereco->setLogradouro($_POST['nome']);
            $endereco->setNumero($_POST['numero']);
            $endereco->setCidade($_POST['cidade']);
            $endereco->setEstado($_POST['estado']);
            $endereco->setPais($_POST['pais']);
            $endereco->setBairro($_POST['bairro']);
            $endereco->setComplemento($_POST['complemento']);
            $endereco->setPontoReferencia($_POST['pontoReferencia']);
            $endereco->setCep($_POST['cep']);

            $professor->setNome($_POST['nome']);
            $professor->setCpf($_POST['cpf']);
            $professor->setEmail($_POST['email']);
            $professor->setTelefone($_POST['telefone']);
            $professor->setDataNascimento(dataStrToObject($_POST['dataNascimento']));
            $professor->setCref($_POST['cref']);
            $professor->setEndereco($endereco);
            
            $this->doctrine->em->flush();
            
            $retorno["erro"] = false;
            $retorno["mensagem"] = "<strong>Sucesso!</strong> Cadastro realizado.";
        } catch (Exception $e) {
            $retorno["mensagem"] = $e->getMessage();
        }

        die(json_encode($retorno));
    }
}
