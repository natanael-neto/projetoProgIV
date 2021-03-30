<?php

use models\bll\AlunoBLL;
use models\bll\EnderecoBLL;
use models\bll\PlanoBLL;
use models\bll\PerfilBLL;
use models\bll\AgendamentoBLL;
use \models\entidades\Aluno;
use \models\entidades\Endereco;

defined('BASEPATH') or exit('No direct script access allowed');

class Alunos extends MY_Controller
{
	public function index()
	{
		if ($this->usuarioLogado->getPerfil()->getNome() == 'aluno') {
			redirect("AlunosAgendamento");
		}

		$alunoBLL = new AlunoBLL();

		$offset = 0;
		if (!empty($_GET['per_page']) && is_numeric($_GET['per_page'])) {
			$offset = $_GET['per_page'];
		}

		$this->load->library('pagination');
		$data['titulo'] = "Alunos";
		$data['alunos'] = $alunoBLL->consultarPaginado($offset, $this->pagination->per_page = 15);

		$get = $_GET;
		unset($get['per_page']);

		$config['base_url'] = site_url('Alunos?' . http_build_query($get));
		$config['total_rows'] = $data['alunos']->count();
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);

		$this->template->load('templateInterno', 'aluno/index', $data);
	}

	public function cadastro()
	{
		$planoBLL = new PlanoBLL();

		$data['titulo'] = "Alunos";
		$data['planos'] = $planoBLL->buscarTodos();

		$this->template->load('templateInterno', 'aluno/cadastro', $data);
	}

	public function editar($id)
	{
		$alunoBLL = new AlunoBLL();
		$planoBLL = new PlanoBLL();

		$data['titulo'] = "Alunos";
		$data['planos'] = $planoBLL->buscarTodos();
		$data['aluno'] = $alunoBLL->buscarPorId($id);

		$this->template->load('templateInterno', 'aluno/cadastro', $data);
	}

	public function cadastroAction()
	{
		try {
			if ($_POST['id']) {
				$alunoBLL = new AlunoBLL();

				$aluno = $alunoBLL->buscarPorId($_POST['id']);
				$endereco = $aluno->getEndereco();
			} else {
				$perfilBLL = new PerfilBLL();

				$aluno = new Aluno();
				$endereco = new Endereco();

				$aluno->setPerfil($perfilBLL->buscarUmPor(array('nome' => 'aluno')));
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

			if (empty($_POST['plano'])) {
				throw new Exception("Por favor, selecione um plano.");
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

			$planoBLL = new PlanoBLL();
			$plano = $planoBLL->buscarPorId($_POST['plano']);

			$endereco->setLogradouro($_POST['logradouro']);
			$endereco->setNumero($_POST['numero']);
			$endereco->setCidade($_POST['cidade']);
			$endereco->setEstado($_POST['estado']);
			$endereco->setPais($_POST['pais']);
			$endereco->setBairro($_POST['bairro']);
			$endereco->setComplemento($_POST['complemento']);
			$endereco->setPontoReferencia($_POST['pontoReferencia']);
			$endereco->setCep($_POST['cep']);

			$aluno->setNome($_POST['nome']);
			$aluno->setCpf($_POST['cpf']);
			$aluno->setEmail($_POST['email']);
			$aluno->setTelefone($_POST['telefone']);
			$aluno->setDataNascimento(dataStrToObject($_POST['dataNascimento']));
			$aluno->setEndereco($endereco);
			$aluno->setPlano($plano);

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
			$alunoBLL = new AlunoBLL();
			$agendamentoBLL = new AgendamentoBLL();

			$agendamentos = $agendamentoBLL->consultar("a.id = {$id}", null, 'e.aluno a');
			$agendamentoBLL->removerTodos($agendamentos);

			$aluno = $alunoBLL->buscarPorId($id);

			$enderecoBLL->removerPorId($aluno->getEndereco()->getId());
			$alunoBLL->removerPorId($aluno->getId());

			$this->doctrine->em->flush();

			$retorno["erro"] = false;
			$retorno["mensagem"] = "<strong>Sucesso!</strong> Excluído com sucesso.";
		} catch (Exception $e) {
			$retorno["mensagem"] = $e->getMessage();
		}

		die(json_encode($retorno));
	}
}
