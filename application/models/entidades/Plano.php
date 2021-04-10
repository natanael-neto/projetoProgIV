<?php

namespace models\entidades;

/**
 * @Entity @Table(name="plano")
 * */
class Plano extends Entidade
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
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $descricao;

    /** 
     * @var Modalidade
     * @ManyToMany(targetEntity="Modalidade", inversedBy="planos")
     * @JoinTable(name="plano_modalidades",
     *      joinColumns={@JoinColumn(name="plano_id", referencedColumnName="id", unique=false)},
     *      inverseJoinColumns={@JoinColumn(name="modalidade_id", referencedColumnName="id", unique=false)}
     *      )
     */
    protected $modalidades;

    public function __construct()
    {
        $this->modalidades = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Modalidade
     */
    public function getModalidades()
    {
        return $this->modalidades;
    }

    /**
     * @param Modalidade $modalidades
     */
    public function setModalidades($modalidades)
    {
        $this->modalidades = $modalidades;
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
}
