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
                    $this->em->getClassMetadata('models\entidades\Endereco')
                );

                $tool->updateSchema($classes);

                $proxyFactory = $this->em->getProxyFactory();
                $metadatas = $this->em->getMetadataFactory()->getAllMetadata();
                $proxyFactory->generateProxyClasses($metadatas);


                $this->alimentarTabelaUsuario();

                echo 'Pronto';
            } catch (Exception $e) {
                print $e;
            }
        }
    }

    protected function alimentarTabelaUsuario()
    {
        $usuarioBLL = new \models\bll\UsuarioBLL();

        $usuarios = $usuarioBLL->buscarTodos();

        if (count($usuarios) == 0) {
            $usuario = new \models\entidades\Usuario();
            $perfil = new \models\entidades\Perfil();

            $perfil->setNome('admin');

            $usuario->setUsername('admin');
            $usuario->setLogin('111.111.111-11');
            $usuario->setPassword(md5('senhasegura'));
            $usuario->setActive(true);
            $usuario->setPerfil($perfil);

            $this->doctrine->em->flush();

            echo 'Criou usuário admin.' . '<br><br>';
        }
    }
}
