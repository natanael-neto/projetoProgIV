<?php

namespace models\bll;

use Doctrine,
    Doctrine\ORM\Query,
    Doctrine\ORM\EntityManager,
    Doctrine\ORM\Tools\Pagination\Paginator,
    models\entidades\Entidade;
use models\entidades\Usuario;

class BaseBLL {

    private $ci;
    protected $db;
    /** @var EntityManager */
    protected $em;
    /** @var \CI_Controller|\MY_Controller|\API_Controller */
    protected $instance;
    protected $nomeEntidade;

    public function __construct() {
        $this->instance = get_instance();
        get_instance()->load->database();
        $this->db = & get_instance()->db;
        $this->em = Doctrine::$ems;
    }

    public function incluir(Entidade $entidade) {
        $this->em->persist($entidade);
    }

    public function remover(Entidade $entidade) {
        //$entidade->setExcluido(true);
        $this->em->remove($entidade);
    }

    public function removerTodos($entidades) {
        if (!is_null($entidades)) {
            foreach ($entidades as $entidade) {
                $this->em->remove($entidade);
            }
        }
    }

    public function removerPorId($id) {
        $entidade = $this->buscarPorId($id);
        $this->em->remove($entidade);
    }

    /**
     * @param null|string $orderBy
     * @param string $order
     * @return mixed
     */
    public function buscarTodos($orderBy = null, $order = 'ASC', $limit = null, $offset= null) {
        if(is_null($orderBy)) {
            return $this->em->getRepository($this->nomeEntidade)->findAll();
        }
        if(is_array($orderBy)){
            return $this->em->getRepository($this->nomeEntidade)->findBy(array(), $orderBy,$limit,$offset);
        }
        else{
            return $this->em->getRepository($this->nomeEntidade)->findBy(array(), array($orderBy => $order),$limit,$offset);
        }
    }

    public function buscarTodosPaginado($offset = 0, $quantidade = 0) {
        $dql = "SELECT e FROM " . $this->nomeEntidade . " e";
        $query = $this->em->createQuery($dql)
                ->setFirstResult($offset)
                ->setMaxResults($quantidade);

        $paginator = new Paginator($query);
        $paginator->setUseOutputWalkers(false);
        return $paginator;
    }

    public function consultarPaginado($offset = 0, $quantidade = 0, $condicao = null, $ordem = null, $join = null, $entidade = "e") {

        if (!is_null($condicao)) {
            $condicao = " WHERE " . $condicao;
        }
        if (!is_null($join)) {
            $join = " " . $join . " ";
        }
        if (!is_null($ordem)) {
            $ordem = " ORDER BY " . $ordem;
        }

        $dql = "SELECT {$entidade} FROM " . $this->nomeEntidade . " e $join $condicao $ordem";

        if($quantidade >= 0) {
            $query = $this->em->createQuery($dql)
                ->setFirstResult($offset)
                ->setMaxResults($quantidade);
        } else {
            $query = $this->em->createQuery($dql);
        }

        $paginator = new Paginator($query);
        $paginator->setUseOutputWalkers(false);
        return $paginator;
    }

    public function buscarPorId($id) {
        return $this->em->find($this->nomeEntidade, $id);
    }

    public function buscarPorIds($id) {
        return $this->em->getRepository($this->nomeEntidade)->findBy(array("id" => $id));
    }

    public function buscarPor($criterios, $ordem = null, $limit = null) {
        return $this->em->getRepository($this->nomeEntidade)->findBy($criterios, $ordem, $limit);
    }

    public function buscarUmPor($criterios) {
        return $this->em->getRepository($this->nomeEntidade)->findOneBy($criterios);
    }

    //protected function ConsultarTodos($nomeEntidade, $ordem = null)
    protected function ConsultarTodos($ordem = null) {
        return $this->Consultar(null, $ordem);
    }

    /**
     * @param null|string $condicao
     * @param null|string $ordem
     * @param null|string $join
     * @param null|string $group
     * @param null|integer $limit
     * @param string $select
     * @return mixed
     */
    public function consultar($condicao = null, $ordem = null, $join = null, $group = null, $limit = null, $select = "e") {
        if (!is_null($condicao)) {
            $condicao = " WHERE " . $condicao;
        }
        if (!is_null($ordem)) {
            $ordem = " ORDER BY " . $ordem;
        }
        if (!is_null($join)) {
            $join = " " . $join . " ";
        }
        if (!is_null($group)) {
            $group = " " . $group . " ";
        }

        /** @var Query $query */
        $query = $this->em->createQuery("SELECT {$select} FROM " . $this->nomeEntidade . " e $join $condicao $group $ordem");

        if (!is_null($limit)) {
            $query->setMaxResults($limit);
        }
        return $query->getResult(Query::HYDRATE_OBJECT);
    }

    public function query($query, $quantidade = null, $return = 'object') {
        $query = $this->em->createQuery($query);

        if (!is_null($quantidade)) {
            $query->setMaxResults($quantidade);
        }

        if ($return == 'object') {
            return $query->getResult(Query::HYDRATE_OBJECT);
        } else if ($return == 'array') {
            return $query->getResult(Query::HYDRATE_ARRAY);
        }
    }

    public function querySql($sql) {
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function queryPaginado($dql, $offset = 0, $quantidade = 0) {
        $query = $this->em->createQuery($dql)
                ->setFirstResult($offset)
                ->setMaxResults($quantidade);

        $paginator = new Paginator($query);
        $paginator->setUseOutputWalkers(false);
        return $paginator;
    }

    public function queryUnico($query) {
        $query = $this->em->createQuery($query)
                ->setMaxResults(1);
        $result = $query->getResult(Query::HYDRATE_OBJECT);
        if (count($result) > 0) {
            return $result[0];
        } else {
            return null;
        }
        //return $query->getSingleResult(Query::HYDRATE_OBJECT);
    }

    protected function QueryUnicoEscalar($query) {
        $query = $this->em->createQuery($query);
        return $query->getSingleScalarResult();
    }

    public function commit() {
        $this->em->flush();
    }

    /**
     * @return bool
     */
    public function hasUsuarioLogado(){
        if(property_exists($this->instance,'usuarioLogado') && !is_null($this->instance->usuarioLogado)){
            return true;
        }
        return false;
    }

    /**
     * @return Usuario
     */
    public function getUsuarioLogado(){
        if($this->hasUsuarioLogado()){
            return $this->instance->usuarioLogado;
        }
        return null;
    }

    public function getNextId(){
        $list = $this->buscarTodos('id','DESC',1);
        if(count($list)>0){
            $id = $list[0]->getId();
            return ++$id;
        }else{
            return 1;
        }
    }
    /**
     * @return \CI_Controller|\MY_Controller|\API_Controller
     */
    protected function ci() {
        if(empty($this->ci)) $this->ci = get_instance();
        return $this->ci;
    }

    /**
     * @return \SystemCfg
     */
    protected function systemcfg() {
        return $this->ci()->systemcfg;
    }
}
