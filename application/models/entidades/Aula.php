<?php

namespace models\entidades;

/**
 * @Entity @Table(name="aula")
 * */
class Aula extends Entidade
{
    /**
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $nome;

    /**
     * @ManyToOne(targetEntity="Modalidade")
     */
    protected $modalidade;

    /**
     * @ManyToOne(targetEntity="Professor")
     */
    protected $professor;

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
     * @return Modalidade|mixed
     */
    public function getModalidade()
    {
        return $this->modalidade;
    }

    /**
     * @param Modalidade $modalidade
     */
    public function setModalidade($modalidade)
    {
        $this->modalidade = $modalidade;
    }


    /**
     * @return Professor|mixed
     */
    public function getProfessor()
    {
        return $this->professor;
    }

    /**
     * @param Professor $professor
     */
    public function setProfessor($professor)
    {
        $this->professor = $professor;
    }
}
