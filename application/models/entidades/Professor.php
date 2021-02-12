<?php

namespace models\entidades;

/**
 * @Entity @Table(name="professor")
 * */
class Professor extends Entidade
{
    /**
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $nome;

    /**
     * @var string
     * @Column(type="string", length=14, nullable=false)
     */
    protected $cpf;

    /**
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $email;

    /**
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $telefone;

    /**
     * @var \DateTime
     * @Column(type="datetime", nullable=false)
     */
    protected $dataNascimento;

    /**
     * @ManyToOne(targetEntity="Endereco")
     */
    protected $endereco;

    /**
     * @Column(type="string", length=100, nullable=false)
     */
    protected $cref;

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
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param string $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    /**
     * @return \DateTime
     */
    public function getDataNascimento()
    {
        return $this->dataNascimento;
    }

    /**
     * @param \DateTime $dataNascimento
     */
    public function setDataNascimento($dataNascimento)
    {
        $this->dataNascimento = $dataNascimento;
    }

    /**
     * @return Endereco
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @param Endereco $endereco
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    /**
     * @return string
     */
    public function getCref()
    {
        return $this->cref;
    }

    /**
     * @param string $cref
     */
    public function setCref($cref)
    {
        $this->cref = $cref;
    }
}
