<?php

use models\bll\ProfessorBLL;
use models\bll\EnderecoBLL;
use models\bll\AulaBLL;
use models\bll\UsuarioBLL;
use models\bll\PerfilBLL;
use \models\entidades\Professor;
use \models\entidades\Endereco;
use models\entidades\Usuario;


defined('BASEPATH') or exit('No direct script access allowed');
class Professores extends MY_Controller
{
    public function index()
    {

        if ($this->usuarioLogado->getPerfil()->getNome() == 'aluno') {
            redirect("AlunosAgendamento");
        }

        $professorBLL = new ProfessorBLL();

        $offset = 0;
        if (!empty($_GET['per_page']) && is_numeric($_GET['per_page'])) {
            $offset = $_GET['per_page'];
        }

        $this->load->library('pagination');
        $data['titulo'] = "Professores";
        $data['professores'] = $professorBLL->consultarPaginado($offset, $this->pagination->per_page = 15);

        $get = $_GET;
        unset($get['per_page']);

        $config['base_url'] = site_url('Professores?' . http_build_query($get));
        $config['total_rows'] = $data['professores']->count();
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);

        $this->template->load('templateInterno', 'professor/index', $data);
    }

    public function cadastro()
    {
        $data['titulo'] = "Professores";
        $this->template->load('templateInterno', 'professor/cadastro', $data);
    }

    public function editar($id)
    {
        $professorBLL = new ProfessorBLL();

        $data['professor'] = $professorBLL->buscarPorId($id);
        $data['titulo'] = "Professores";
        $this->template->load('templateInterno', 'professor/cadastro', $data);
    }

    public function cadastroAction()
    {
        try {
            if ($_POST['id']) {
                $professorBLL = new ProfessorBLL();

                $professor = $professorBLL->buscarPorId($_POST['id']);
                $endereco = $professor->getEndereco();
                $usuario = $professor->getUsuario();
            } else {
                $professor = new Professor();
                $endereco = new Endereco();
                $usuario = new Usuario();
            }

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

            if (empty($_POST['numero']) || !is_numeric($_POST['numero'])) {
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

            if (empty($_POST['cep'])) {
                throw new Exception("Por favor, digite um CEP válido.");
            }

            $perfilBLL = new PerfilBLL();

            $usuario->setPerfil($perfilBLL->buscarUmPor(array('nome' => 'funcionario')));
			$usuario->setLogin($_POST['cpf']);
			$usuario->setUsername($_POST['nome']);
			$usuario->setActive(true);
			$usuario->setEmail($_POST['email']);

            if (empty($usuario->getId())) {
				$senha = gerar_senha();
				$usuario->setPassword(md5($senha));
			}

            $endereco->setLogradouro($_POST['logradouro']);
            $endereco->setNumero($_POST['numero']);
            $endereco->setCidade($_POST['cidade']);
            $endereco->setEstado($_POST['estado']);
            $endereco->setPais($_POST['pais']);
            $endereco->setBairro($_POST['bairro']);
            $endereco->setComplemento($_POST['complemento']);
            $endereco->setPontoReferencia($_POST['pontoReferencia']);
            $endereco->setCep($_POST['cep']);

            $professor->setUsuario($usuario);
            $professor->setNome($_POST['nome']);
            $professor->setCpf($_POST['cpf']);
            //$professor->setEmail($_POST['email']);
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

    public function excluir($id = null)
    {
        try {
            $retorno = array('erro' => true);

            if (empty($id)) {
                throw new Exception('ID inválido.');
            }
            $enderecoBLL = new EnderecoBLL();
            $professorBLL = new ProfessorBLL();
            $aulaBLL = new AulaBLL();
            $usuarioBLL = new UsuarioBLL();

            $aulas = $aulaBLL->consultar("p.id = {$id}", null, "JOIN e.professor p");

            if (count($aulas) > 0) {
                throw new Exception('Este professor está cadastrado em aula. Por favor, transfira as aulas para outro professor.');
            }

            $professor = $professorBLL->buscarPorId($id);

            $usuarioBLL->removerPorId($professor->getUsuario()->getId());
            $enderecoBLL->removerPorId($professor->getEndereco()->getId());
            $professorBLL->removerPorId($professor->getId());

            $this->doctrine->em->flush();

            $retorno["erro"] = false;
            $retorno["mensagem"] = "<strong>Sucesso!</strong> Excluído com sucesso.";
        } catch (Exception $e) {
            $retorno["mensagem"] = $e->getMessage();
        }

        die(json_encode($retorno));
    }
}