<?php

namespace models\entidades;

/**
 * @Entity @Table(name="aula")
 * */
class Aula extends Entidade
{
    /**
     * @var integer
     * @Column(type="integer", nullable=false)
     */
    protected $capacidade;

    /**
     * @Column(type="time", nullable=false)
     */
    protected $horario;

    /**
     * @ManyToOne(targetEntity="Modalidade")
     */
    protected $modalidade;

    /**
     * @ManyToOne(targetEntity="Professor")
     */
    protected $professor;

    /**
     * @return integer
     */
    public function getCapacidade()
    {
        return $this->capacidade;
    }

    /**
     * @param integer $capacidade
     */
    public function setCapacidade($capacidade)
    {
        $this->capacidade = $capacidade;
    }

    public function getHorario()
    {
        return $this->horario;
    }

    public function setHorario($horario)
    {
        $this->horario = $horario;
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
