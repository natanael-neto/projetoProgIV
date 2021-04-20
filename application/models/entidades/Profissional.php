<?php

namespace models\entidades;

/**
 * @Entity @Table(name="profissional")
 * */
class Profissional extends Entidade
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
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    protected $funcao;

    /**
     * @var integer
     * @Column(type="integer", nullable=false)
     */
    protected $cargaHoraria;

    /**
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $inicioJornada;

    /**
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $saidaJornada;

    /**
     * @var \DateTime
     * @Column(type="datetime", nullable=false)
     */
    protected $dataNascimento;

    /**
     * @OneToOne(targetEntity="Usuario", inversedBy="profissional")
     * @JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;


    /**
     * @ManyToOne(targetEntity="Endereco")
     */
    protected $endereco;

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
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param Usuario $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
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
    public function getFuncao()
    {
        return $this->funcao;
    }

    /**
     * @param string $funcao
     */
    public function setFuncao($funcao)
    {
        $this->funcao = $funcao;
    }

    /**
     * @return integer
     */
    public function getCargaHoraria()
    {
        return $this->cargaHoraria;
    }

    /**
     * @param integer $cargaHoraria
     */
    public function setCargaHoraria($cargaHoraria)
    {
        $this->cargaHoraria = $cargaHoraria;
    }

    /**
     * @return string
     */
    public function getInicioJornada()
    {
        return $this->inicioJornada;
    }

    /**
     * @param string $inicioJornada
     */
    public function setInicioJornada($inicioJornada)
    {
        $this->inicioJornada = $inicioJornada;
    }

    /**
     * @return string
     */
    public function getSaidaJornada()
    {
        return $this->saidaJornada;
    }

    /**
     * @param string $saidaJornada
     */
    public function setSaidaJornada($saidaJornada)
    {
        $this->saidaJornada = $saidaJornada;
    }
}
