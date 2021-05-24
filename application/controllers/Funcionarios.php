<?php

use models\bll\ProfissionalBLL;
use models\bll\EnderecoBLL;
use models\bll\PerfilBLL;
use models\bll\UsuarioBLL;
use models\entidades\Usuario;
use \models\entidades\Profissional;
use \models\entidades\Endereco;


defined('BASEPATH') or exit('No direct script access allowed');
class Funcionarios extends MY_Controller
{
    public function index()
    {

        if ($this->usuarioLogado->getPerfil()->getNome() == 'aluno') {
            redirect("AlunosAgendamento");
        } else if ($this->usuarioLogado->getPerfil()->getNome() == 'funcionario') {
            redirect("Inicio");
        }

        $profissionalBLL = new ProfissionalBLL();

        $offset = 0;
        if (!empty($_GET['per_page']) && is_numeric($_GET['per_page'])) {
            $offset = $_GET['per_page'];
        }

        $this->load->library('pagination');
        $data['titulo'] = "Funcionários";
        $data['funcionarios'] = $profissionalBLL->consultarPaginado($offset, $this->pagination->per_page = 15);

        $get = $_GET;
        unset($get['per_page']);

        $config['base_url'] = site_url('Funcionarios?' . http_build_query($get));
        $config['total_rows'] = $data['funcionarios']->count();
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);

        $this->template->load('templateInterno', 'funcionario/index', $data);
    }

    public function cadastro()
    {
        $perfilBLL = new PerfilBLL();

        $data['titulo'] = "Funcionários";
        $data['perfis'] = $perfilBLL->buscarTodos();
        $this->template->load('templateInterno', 'funcionario/cadastro', $data);
    }

    public function editar($id)
    {
        $profissionalBLL = new ProfissionalBLL();
        $perfilBLL = new PerfilBLL();

        $data['funcionario'] = $profissionalBLL->buscarPorId($id);
        $data['perfis'] = $perfilBLL->buscarTodos();

        $data['titulo'] = "Funcionários";
        $this->template->load('templateInterno', 'funcionario/cadastro', $data);
    }

    public function cadastroAction()
    {
        try {
            $profissionalBLL = new ProfissionalBLL();

            if ($_POST['id']) {
                $funcionario = $profissionalBLL->buscarPorId($_POST['id']);
                $endereco = $funcionario->getEndereco();
                $usuario = $funcionario->getUsuario();
            } else {
                $funcionario = new Profissional();
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

            $validarCpfExistente = $profissionalBLL->buscarPor(array('cpf' => $_POST['cpf']));

            if (!$_POST['id'] && count($validarCpfExistente) >= 1) {
                throw new Exception("Já existe um profissional cadastrado com esse CPF.");
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

            if (empty($_POST['funcao'])) {
                throw new Exception("Por favor, digite um função.");
            }

            if (empty($_POST['inicioJornada'])) {
                throw new Exception("Por favor, digite uma jornada inicial.");
            } else {
                $horas = explode(':', $_POST['inicioJornada']);

                if (((int) $horas[0] < 0 || (int) $horas[0] > 24) || ((int) $horas[1] < 0 || (int) $horas[1] > 60)) {
                    throw new Exception("Por favor, digite uma jornada inicial válida.");
                }
            }

            if (empty($_POST['saidaJornada'])) {
                throw new Exception("Por favor, digite um jornada final.");
            } else {
                $horas = explode(':', $_POST['saidaJornada']);

                if (((int) $horas[0] < 0 || (int) $horas[0] > 24) || ((int) $horas[1] < 0 || (int) $horas[1] > 60)) {
                    throw new Exception("Por favor, digite uma jornada final válida.");
                }
            }

            if (empty($_POST['cargaHoraria']) || ((int) $_POST['cargaHoraria'] < 0 || (int) $_POST['cargaHoraria'] > 12)) {
                throw new Exception("Por favor, digite uma carga horária válida. (Entre 0 e 12 horas diárias)");
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

            $endereco->setLogradouro($_POST['logradouro']);
            $endereco->setNumero($_POST['numero']);
            $endereco->setCidade($_POST['cidade']);
            $endereco->setEstado($_POST['estado']);
            $endereco->setPais($_POST['pais']);
            $endereco->setBairro($_POST['bairro']);
            $endereco->setComplemento($_POST['complemento']);
            $endereco->setPontoReferencia($_POST['pontoReferencia']);
            $endereco->setCep($_POST['cep']);

            $perfilBLL = new PerfilBLL();

            $usuario->setPerfil($perfilBLL->buscarPorId($_POST['perfil']));
            $usuario->setLogin($_POST['cpf']);
            $usuario->setUsername($_POST['nome']);
            $usuario->setActive(true);

            if (empty($usuario->getId())) {
                $senha = gerar_senha();
                $usuario->setPassword(md5($senha));
            }

            $funcionario->setUsuario($usuario);
            $funcionario->setNome($_POST['nome']);
            $funcionario->setCpf($_POST['cpf']);
            $funcionario->setEmail($_POST['email']);
            $funcionario->setTelefone($_POST['telefone']);
            $funcionario->setDataNascimento(dataStrToObject($_POST['dataNascimento']));
            $funcionario->setInicioJornada($_POST['inicioJornada']);
            $funcionario->setSaidaJornada($_POST['saidaJornada']);
            $funcionario->setCargaHoraria($_POST['cargaHoraria']);
            $funcionario->setFuncao($_POST['funcao']);
            $funcionario->setEndereco($endereco);
            
            $this->doctrine->em->flush();
            
            if (!$_POST['id']) {
                $this->load->library('email');
                $this->email->from("sisctrlgym@email.com", "Academia SisCtrl");
                $this->email->to("{$_POST['email']}");
                $this->email->subject('Confirmação de cadastro');
                $this->email->message("Olá, {$_POST['nome']}! Seu cadastro foi confirmado no sistema da Academia SisCtrl! Seu login é o seu CPF: {$_POST['cpf']} e sua senha é {$senha}.");
                $this->email->send();
            }

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

            $profissionalBLL = new ProfissionalBLL();
            $enderecoBLL = new EnderecoBLL();
            $usuarioBLL = new UsuarioBLL();

            $funcionario = $profissionalBLL->buscarPorId($id);

            $usuarioBLL->removerPorId($funcionario->getUsuario()->getId());
            $enderecoBLL->removerPorId($funcionario->getEndereco()->getId());
            $profissionalBLL->removerPorId($funcionario->getId());

            $this->doctrine->em->flush();

            $retorno["erro"] = false;
            $retorno["mensagem"] = "<strong>Sucesso!</strong> Excluído com sucesso.";
        } catch (Exception $e) {
            $retorno["mensagem"] = $e->getMessage();
        }

        die(json_encode($retorno));
    }
}
