<?php

class Doctrine_tools extends CI_Controller
{

    //Doctrine EntityManager
    public $em;

    function __construct()
    {
        parent::__construct();

        //Instantiate a Doctrine Entity Manager
        $this->em = $this->doctrine->em;
    }

    function index()
    {
        echo 'Doctrine: Atualizar estrutura do banco de dados.<br /><br />
		<form action="" method="POST">
		<input type="submit" name="action" value="Atualizar Banco"><br /><br />
                </form>';

        if ($this->input->post('action')) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            try {
                $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);

                $filter_exclude = [
                    'auth_user_autologin',
                    'auth_user_profiles',
                    'ci_sessions'
                ];

                $exclude_reg = '/^(?!(?:' . implode('|', $filter_exclude) . ')$).*$/';
                $this->doctrine->em->getConfiguration()->setFilterSchemaAssetsExpression($exclude_reg);

                $classes = array(
                    $this->em->getClassMetadata('models\entidades\Entidade'),
                    $this->em->getClassMetadata('models\entidades\Aluno'),
                    $this->em->getClassMetadata('models\entidades\Perfil'),
                    $this->em->getClassMetadata('models\entidades\Plano'),
                    $this->em->getClassMetadata('models\entidades\Modalidade'),
                    $this->em->getClassMetadata('models\entidades\Aula'),
                    $this->em->getClassMetadata('models\entidades\Professor'),
                    $this->em->getClassMetadata('models\entidades\Agendamento'),
                    $this->em->getClassMetadata('models\entidades\Profissional'),
                    $this->em->getClassMetadata('models\entidades\Usuario'),
                    $this->em->getClassMetadata('models\entidades\Endereco'),
                    $this->em->getClassMetadata('models\entidades\Medida'),
                    $this->em->getClassMetadata('models\entidades\Exercicio'),
                    $this->em->getClassMetadata('models\entidades\Categoria'),
                    $this->em->getClassMetadata('models\entidades\Requisicao')
  
                );

                $tool->updateSchema($classes);

                $proxyFactory = $this->em->getProxyFactory();
                $metadatas = $this->em->getMetadataFactory()->getAllMetadata();
                $proxyFactory->generateProxyClasses($metadatas);


                $this->alimentarTabelaPerfil();
                $this->alimentarTabelaUsuario();

                echo 'Pronto';
            } catch (Exception $e) {
                print $e;
            }
        }
    }

    protected function alimentarTabelaPerfil()
    {
        $perfilBLL = new \models\bll\PerfilBLL();

        $perfis = $perfilBLL->buscarTodos();

        if (count($perfis) == 0) {
            $perfilAluno = new \models\entidades\Perfil();
            $perfilFuncionario = new \models\entidades\Perfil();
            $perfilAdmin = new \models\entidades\Perfil();

            $perfilFuncionario->setNome('funcionario');
            $perfilAluno->setNome('aluno');
            $perfilAdmin->setNome('admin');

            $this->doctrine->em->flush();

            echo '<br><br>' . 'Criou os perfis.' . '<br><br>';
        }
    }

    protected function alimentarTabelaUsuario()
    {
        $usuarioBLL = new \models\bll\UsuarioBLL();
        $perfilBLL = new \models\bll\PerfilBLL();

        $usuarios = $usuarioBLL->buscarTodos();

        if (count($usuarios) == 0) {
            $usuarioAdmin = new \models\entidades\Usuario();
            $usuarioAluno = new \models\entidades\Usuario();

            $perfilAdmin = $perfilBLL->buscarUmPor(array('nome' => 'admin'));
            $perfilAluno = $perfilBLL->buscarUmPor(array('nome' => 'aluno'));

            $usuarioAluno->setUsername('aluno');
            $usuarioAluno->setLogin('222.222.222-22');
            $usuarioAluno->setEmail('aluno@gmail.com');
            $usuarioAluno->setPassword(md5('facol123'));
            $usuarioAluno->setActive(true);
            $usuarioAluno->setPerfil($perfilAluno);

            $usuarioAdmin->setUsername('admin');
            $usuarioAdmin->setLogin('111.111.111-11');
            $usuarioAdmin->setEmail('admin@gmail.com');
            $usuarioAdmin->setPassword(md5('facol123'));
            $usuarioAdmin->setActive(true);
            $usuarioAdmin->setPerfil($perfilAdmin);

            $this->doctrine->em->flush();

            echo 'Criou usuários admin e aluno para teste.' . '<br><br>';
        }
    }
}
