<?php

namespace models\entidades;

/**
 * @Entity @Table(name="agendamento")
 * */
class Agendamento extends Entidade
{
    /**
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $observacao;
    
    /**
     * @var \DateTime
     * @Column(type="datetime", nullable=false)
     */
    protected $dataAgendamento;

    /**
     * @OneToOne(targetEntity="Aula")
     */
    protected $aula;

    /**
     * @ManyToOne(targetEntity="Aluno")
     */
    protected $aluno;

    /**
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * @param string $observacao
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
    }

    /**
     * @return \DateTime
     */
    public function getDataAgendamento()
    {
        return $this->dataAgendamento;
    }

    /**
     * @param \DateTime $dataAgendamento
     */
    public function setDataAgendamento($dataAgendamento)
    {
        $this->dataAgendamento = $dataAgendamento;
    }

    /**
     * @return Aula|mixed
     */
    public function getAula()
    {
        return $this->aula;
    }

    /**
     * @param Aula $aula
     */
    public function setAula($aula)
    {
        $this->aula = $aula;
    }

    /**
     * @return Aluno|mixed
     */
    public function getAluno()
    {
        return $this->aluno;
    }

    /**
     * @param Aluno $aluno
     */
    public function setAluno($aluno)
    {
        $this->aluno = $aluno;
    }
}
