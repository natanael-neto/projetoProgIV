<?php

namespace models\entidades;

/**
 * @Entity @Table(name="agendamento")
 * */
class Agendamento extends Entidade
{
    /**
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $nome;

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
