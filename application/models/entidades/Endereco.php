<?php

namespace models\entidades;

/**
 * @Entity @Table(name="endereco")
 **/
class Endereco extends Entidade
{
    /**
     * @Column(type="string", length=255, nullable=false)
     */
    protected $logradouro;

    /**
     * @Column(type="string", length=255, nullable=false)
     */
    protected $numero;

    /**
     * @Column(type="string", length=100, nullable=false )
     */
    protected $complemento;

    /**
     * @Column(type="string", length=255, nullable=false)
     */
    protected $bairro;

    /**
     * @Column(type="string", length=11, nullable=false)
     */
    protected $cep;

    /**
     * @Column(type="string", length=255, nullable=false)
     */
    protected $cidade;

    /**
     * @Column(type="string", length=255, nullable=false)
     */
    protected $estado;

    /**
     * @Column(type="string", length=255, nullable=false)
     */
    protected $pais;

    /**
     * @Column(type="string", length=255, nullable=false)
     */
    protected $pontoReferencia;

    public function getLogradouro()
    {
        return $this->logradouro;
    }

    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function getComplemento()
    {
        return $this->complemento;
    }

    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
    }

    public function getBairro()
    {
        return $this->bairro;
    }

    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    /**
     * @return string
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    function getPontoReferencia()
    {
        return $this->pontoReferencia;
    }

    function setPontoReferencia($pontoReferencia)
    {
        $this->pontoReferencia = $pontoReferencia;
    }

    /**
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param string $pais
     */
    public function setPais($pais)
    {
        $this->pais = $pais;
    }

    public function isValido()
    {
        if (empty($this->logradouro) || empty($this->numero) || empty($this->cidade) || empty($this->bairro) || empty($this->cep)) {
            return false;
        }

        return true;
    }
}
