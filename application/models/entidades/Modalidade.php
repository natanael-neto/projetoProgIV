<?php

namespace models\entidades;

/**
 * @Entity @Table(name="modalidade")
 * */
class Modalidade extends Entidade
{
    /**
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $nome;

    /**
     * @var string
     * @Column(type="string", length=500, nullable=false)
     */
    protected $descricao;

    /**
     * @var mixed
     * @ManyToMany(targetEntity="Plano", mappedBy="modalidades", cascade={"persist", "remove"})
     */
    protected $planos;

    public function __construct()
    {
        parent::__construct();
        $this->planos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return mixed
     */
    public function getPlanos()
    {
        return $this->planos;
    }

    /**
     * @param mixed $planos
     */
    public function setPlanos($planos)
    {
        $this->planos = $planos;
    }
}
