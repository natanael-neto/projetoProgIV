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
     * @var Plano
     * @ManyToMany(targetEntity="Plano", mappedBy="modalidades", cascade={"persist", "remove"})
     */
    protected $planos;

    /**
     * @var Exercicio
     * @ManyToMany(targetEntity="Exercicio", mappedBy="modalidades")
     */
    protected $exercicios;

    public function __construct()
    {
        parent::__construct();
        $this->planos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->exercicios = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Plano
     */
    public function getPlanos()
    {
        return $this->planos;
    }

    /**
     * @param Plano $planos
     */
    public function setPlanos($planos)
    {
        $this->planos = $planos;
    }

    /**
     * @return Exercicio
     */
    public function getExercicios()
    {
        return $this->exercicios;
    }

    /**
     * @param Exercicio $exercicios
     */
    public function setExercicios($exercicios)
    {
        $this->exercicios = $exercicios;
    }
}
