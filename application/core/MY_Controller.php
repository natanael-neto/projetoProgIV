<?php

use models\entidades\Usuario;
use models\negocio\ConfiguracaoBLL;
use Firebase\JWT\JWT;

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Configuracao $configuracao
 * @property Usuario $usuarioLogado
 * @property boolean $isDebugMode
 */
class MY_Controller extends CI_Controller
{
    public $data = array();
    public $usuarioLogado = null;
    public $permissao = null;
    protected $configuracao;
    protected $scripts = array();

    public function getScripts()
    {
        return $this->scripts; 
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->debugMode('sisgr');

        $this->getCurrentConfig();

        $this->output->cache(0);

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

        getVersao($this);

        $this->checarAutenticacao();

        $this->data["menuAtivo"] = array();

        $this->data["habilitarScript"] = function ($name) {
            array_push($this->scripts, $name);
        };
        $this->data["carregarScripts"] = function () {
            carregarScripts();
        };

        if ($this->tank_auth->is_logged_in()) {
            $usuarioBLL = new \models\negocio\UsuarioBLL();
            $this->usuarioLogado = $usuarioBLL->buscarPorId($this->tank_auth->get_user_id());
            $this->data["usuarioLogado"] = $this->usuarioLogado;

            if ($this->usuarioLogado->getProfissional()) {
                $notificacaoBLL = new \models\negocio\NotificacaoBLL();
                $this->data["notificacoes"] = $notificacaoBLL->buscarPor(array("profissional" => $this->usuarioLogado->getProfissional()->getId()), array("dataRegistro" => "DESC"), 20);
            } else {
                $this->data["notificacoes"] = [];
            }


            $tipoResiduoBLL = new \models\negocio\TipoResiduoBLL();
            $this->data["tiposResiduos"] = $tipoResiduoBLL->buscarTodos();
        }
    }

    protected function saveFilters($name = "") {
        list($childClass, $caller) = debug_backtrace(false, 2);
        $class = $caller['class'];
        $function = $caller['function'];

        $slug = strtolower($class).((!empty($name))?"-{$name}":"-{$function}");
        if(!empty($_GET) && array_key_exists("checkFilters", $_GET) && !empty($_COOKIE["{$slug}-filtros"])) {
            $filters = json_encode(unserialize($_COOKIE["{$slug}-filtros"]), JSON_PRETTY_PRINT);
            $pre = "<pre class='check-filters'>{$filters}</pre>";
            echo "<div id='check-filters'>{$pre}</div>";
            unset($_GET['checkFilters']);
        }
        if(empty($_GET) && !empty($_COOKIE["{$slug}-filtros"])) {
            $_GET = unserialize($_COOKIE["{$slug}-filtros"]);
            unset($_GET['per_page']);
            unset($_GET['exportar']);
            unset($_GET['saveFilter']);
        } elseif(isset($_GET['saveFilter'])) {
            setcookie("{$slug}-filtros", serialize($_GET), 0, "/");
        }
    }

    private function debugMode($code = 'debug')
    {
        if (!empty($_GET['debug'])) {
            if ($_GET['debug'] == $code) {
                $this->session->set_userdata('debug_mode', true);
            } elseif ($_GET['debug'] == 'off') {
                $this->session->unset_userdata('debug_mode');
            }
        }
        $debugMode = $this->session->userdata('debug_mode');
        if (!empty($debugMode) && $debugMode) {
            $this->isDebugMode = true;
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            $this->data['debugModeHTML'] = '<a style="position: fixed; right: 0; top: 0; z-index: 99999;" href="?debug=off" title="Clique para desativar" rel="tooltip" data-placement="left"><div style="background: red; color:#FFF; font-weight: bold; padding: 2px 8px; border-radius: 0 0 0 10px; opacity: 0.8; font-size: 10px;">DebugMode</div></a>';
        } else {
            $this->isDebugMode = false;
        }
        $this->data['isDebugMode'] = $this->isDebugMode;
    }

    protected function checarAutenticacao()
    {
        if (!$this->tank_auth->is_logged_in()) {
            if (!empty($_SERVER['REDIRECT_URL'])) {
                $this->session->set_userdata('redirect_url', $_SERVER['REDIRECT_URL']);
                redirect('/auth/login/#' . str_replace(preg_replace('/\/index.php.*/', '', $_SERVER['PHP_SELF']), '', $_SERVER['REDIRECT_URL']));
            } else {
                redirect('/auth/login/#');
            }
            exit;
        }
    }

    protected function logAtualizacao($valor, $entidade)
    {
        if (method_exists($entidade, 'getVolume')) {
            if ($valor != $entidade->getVolume()) {
                $logAtualizacao = new \models\entidades\LogAtualizacao();

                $logAtualizacao->setValorAnterior($entidade->getVolume());
                $logAtualizacao->setNovoValor($valor);
                $logAtualizacao->setEntidadeId($entidade->getId());
                $logAtualizacao->setIdentificacao($entidade->getId());
                $logAtualizacao->setEntidade(getOptions('tipoAtualizacao', str_replace("models\\entidades\\", '', get_class($entidade))));
                $logAtualizacao->setUsuario($this->usuarioLogado);

                $this->doctrine->em->flush();
            }
        } else if ($entidade instanceof \models\entidades\Cliente) {
            foreach ($entidade->getValores() as $valEntidade) {
                unset($encontrado);
                foreach ($valor as $val) {
                    if ($val->getTipoResiduo()->getId() == $valEntidade->getTipoResiduo()->getId()) {
                        if ($val->getValor() != $valEntidade->getValor()) {
                            $logAtualizacao = new \models\entidades\LogAtualizacao();

                            $logAtualizacao->setValorAnterior($valEntidade->getValor());
                            $logAtualizacao->setNovoValor($val->getValor());
                            $logAtualizacao->setEntidadeId($entidade->getId());
                            $logAtualizacao->setIdentificacao($entidade->getId() . " - " . $entidade->getNome() . " - " . $valEntidade->getTipoResiduo()->getNome());
                            $logAtualizacao->setEntidade(getOptions('tipoAtualizacao', str_replace("models\\entidades\\", '', get_class($entidade))));
                            $logAtualizacao->setUsuario($this->usuarioLogado);

                            $this->doctrine->em->flush();
                        }
                        $encontrado = true;
                        break;
                    }
                }
                //Logar Exclusão de Valores
                if (!isset($encontrado)) {
                    $logAtualizacao = new \models\entidades\LogAtualizacao();

                    $logAtualizacao->setValorAnterior($valEntidade->getValor());
                    $logAtualizacao->setNovoValor(null);
                    $logAtualizacao->setEntidadeId($entidade->getId());
                    $logAtualizacao->setIdentificacao($entidade->getId() . " - " . $entidade->getNome() . " - " . $valEntidade->getTipoResiduo()->getNome());
                    $logAtualizacao->setEntidade(getOptions('tipoAtualizacao', str_replace("models\\entidades\\", '', get_class($entidade))));
                    $logAtualizacao->setUsuario($this->usuarioLogado);

                    $this->doctrine->em->flush();
                }
            }
        }
    }
    public function view($view, $vars = NULL, $return = FALSE)
    {
        $viewAlt = "{$view}/" . getSystemSlug();
        if (file_exists(APPPATH . "views/{$viewAlt}.php")) {
            $view = $viewAlt;
        } elseif(file_exists(APPPATH."views/{$view}/_default.php")){
            $view = "{$view}/_default";
        }

        if (is_null($vars)) {
            $vars = $this->data;
        } else {
            array_merge($this->data, $vars);
        }
        if (isset($_GET['navAsAjax'])) {
            $result = $this->load->view($view, $vars, true);
        } else {
            $vars['pageContent'] = $this->load->view($view, $vars, true);

            $result = $this->load->view('layout/framework', $vars, true);
        }
        if ($return) {
            return $result;
        } else {
            print $result;
        }
    }

    /**
     * @return Configuracao
     */
    public function getConfiguracao()
    {
        return $this->configuracao;
    }

    private function getCurrentConfig($defaultConfig = 1)
    {
        $configuracaoBLL = new ConfiguracaoBLL();

        if (ENVIRONMENT == 'development') {
            if (!empty($_COOKIE['currentConfig']) && empty($_GET['config'])) {
                $this->configuracao = $configuracaoBLL->buscarUmPor(array('slug' => $_COOKIE['currentConfig']));
            } elseif (!empty($_GET['config'])) {
                $this->configuracao = $configuracaoBLL->buscarUmPor(array('slug' => $_GET['config']));
                if (is_null($this->configuracao)) {
                    $configArray = array();

                    /** @var Configuracao $config */
                    foreach ($configuracaoBLL->buscarPor(array()) as $config) {
                        array_push($configArray, $config->getSlug() . (($config->getId() == $defaultConfig) ? " (Padrão)" : ""));
                    }

                    unset($_COOKIE['currentConfig']);
                    setcookie('currentConfig', '', time() - 3600, '/');

                    die("Configuração \"" . $_GET['config'] . "\" não encontrada<br><br>Configurações Disponiveis:<br>" . implode('<br>', $configArray));
                } else {
                    setcookie('currentConfig', $_GET['config'], null, '/');
                }
            } else {
                $this->configuracao = $configuracaoBLL->buscarPorId($defaultConfig);
            }
        } else {
            $this->configuracao = $configuracaoBLL->buscarPorId($defaultConfig);
        }

        $this->data['_configuracao'] = $this->configuracao;
    }

    protected function json_response($body, $http_code = 200)
    {
        $this->output
            ->set_content_type('application/json', 'UTF-8')
            ->set_status_header($http_code)
            ->set_output(json_encode($body))
            ->_display();

        exit;
    }

    public function visualizar($id) {
        if (!$this->usuarioLogado->temPermissao($this->permissao, false, 'ignoreWritePermission')) {
            die("Sem permissão");
        }
        if(method_exists($this, 'editar')) {
            $this->data['visualizar'] = true;
            $this->editar($id);
        }
    }

    public function semPermissaoPage($mensagem = 'Você não possui permissão para acessar essa área', $return = false) {
        if(!is_null($mensagem)) {
            $this->data['mensagem'] = $mensagem;
        }
        if($return) {
            return $this->view('perfisacesso/semPermissao', null, $return);
        } else {
            $this->view('perfisacesso/semPermissao', null, $return);
            die();
        }
    }
}

/**
 * @property Usuario $currentUser
 * @property boolean $isDebugMode
 */
class API_Controller extends CI_Controller
{
    protected $authenticate_user = false;
    protected $authenticate_only = [];
    protected $currentUser;

    public function __construct()
    {
        parent::__construct();
        $this->debugMode('sisgr');
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        $this->output->set_header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
        $this->output->set_header('Access-Control-Allow-Credentials: true');

        $action = $this->router->method;
        $serverRequestMethod = $this->input->server('REQUEST_METHOD');

        if ($this->authenticate_user && $serverRequestMethod != 'OPTIONS') {
            if (count($this->authenticate_only) > 0) {
                if (in_array($action, $this->authenticate_only)) {
                    $this->check_token();
                }
            } else {
                $this->check_token();
            }
        } else if ($serverRequestMethod == 'OPTIONS') {
            $this->json_response(['request' => 'accepted'], 200);
        }
    }

    protected function input_raw($input)
    {
        $raw = json_decode(file_get_contents('php://input'));
        if (is_object($raw) && property_exists($raw, $input)) {
            return $raw->$input;
        }
        return null;
    }

    protected function request_method($action)
    {
        $serverRequestMethod = $this->input->server('REQUEST_METHOD');

        if ($serverRequestMethod == 'OPTIONS') {
            $this->json_response(['request' => 'accepted'], 200);
        }

        if ($serverRequestMethod != $action) {
            $this->json_response(array('message' => 'action not found'), 404);
        }
    }

    protected function check_token()
    {
        try {
            $headers = $this->input->request_headers();
            $tokenHeader = trim(@$headers['Authorization']);
            $token = $this->getBearerToken($tokenHeader);

            if ($token) {
                $jwt = JWT::decode($token, SECRET_KEY, array('HS256'));

                $usuarioBll = new models\negocio\UsuarioBLL();
                $this->currentUser = $usuarioBll->buscarPorId($jwt->user->id);

                if (count($this->currentUser->getApiToken($token)) < 1) {
                    $this->json_response(array('message' => 'not authorized'), 401);
                }
            } else {
                $this->json_response(array('message' => 'token not informed'), 401);
            }
        } catch (Exception $e) {
            $this->json_response(array('message' => $e->getMessage()), 401);
        }
    }

    protected function getBearerToken($token)
    {
        if (!empty($token)) {
            if (preg_match('/Bearer\s(\S+)/', $token, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    protected function json_response($body, $http_code = 200)
    {
        $this->output
            ->set_content_type('application/json', 'UTF-8')
            ->set_status_header($http_code)
            ->set_output(json_encode($body))
            ->_display();

        exit;
    }

    private function debugMode($code = 'debug')
    {
        if (!empty($_GET['debug'])) {
            if ($_GET['debug'] == $code) {
                $this->session->set_userdata('debug_mode', true);
            } elseif ($_GET['debug'] == 'off') {
                $this->session->unset_userdata('debug_mode');
            }
        }
        $debugMode = $this->session->userdata('debug_mode');
        if (!empty($debugMode) && $debugMode) {
            $this->isDebugMode = true;
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            $this->data['debugModeHTML'] = '<a style="position: fixed; right: 0; top: 0; z-index: 99999;" href="?debug=off" title="Clique para desativar" rel="tooltip" data-placement="left"><div style="background: red; color:#FFF; font-weight: bold; padding: 2px 8px; border-radius: 0 0 0 10px; opacity: 0.8; font-size: 10px;">DebugMode</div></a>';
        } else {
            $this->isDebugMode = false;
        }
        $this->data['isDebugMode'] = $this->isDebugMode;
    }

    /**
     * @return Usuario
     */
    public function getCurrentUser() {
        return $this->currentUser;
    }

    /**
     * @return string
     */
    public function getApiToken() {
        $headers = $this->input->request_headers();
        $tokenHeader = trim(@$headers['Authorization']);
        return $this->getBearerToken($tokenHeader);
    }
}
