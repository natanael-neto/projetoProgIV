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
     * @ManyToMany(targetEntity="Modalidade")
     * @JoinTable(name="plano_modalidades",
     *      joinColumns={@JoinColumn(name="plano_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="modalidade", referencedColumnName="id", unique=true)}
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
     * @return Modalidade[]|@mixed
     */
    public function getModalidades()
    {
        return $this->modalidades;
    }

    /**
     * @param Modalidade $modalidade
     */
    public function setModalidade($modalidade)
    {
        $this->modalidade = $modalidade;
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
