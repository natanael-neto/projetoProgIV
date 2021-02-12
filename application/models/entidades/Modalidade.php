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
     * @var float
     * @Column(type="float", nullable=false)
     */
    protected $valor;

    /**
     * @ManyToMany(targetEntity="Plano", inversedBy="modalidades")
     */
    protected $planos;

    public function __construct()
    {
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
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param float $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * @return Plano[]|mixed
     */
    public function getPlanos()
    {
        return $this->planos;
    }

    /**
     * @param Plano $plano
     */
    public function setPlano($plano)
    {
        $this->plano = $plano;
    }
}
