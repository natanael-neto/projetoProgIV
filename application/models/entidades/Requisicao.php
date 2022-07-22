<?php

namespace models\entidades;

/**
 * @Entity @Table(name="requisicao")
 * */
class Requisicao extends Entidade{

    /**
     * @ManyToOne(targetEntity="Usuario")
     */
    protected $usuario;

    /**
     * @Column(type="boolean", nullable=false)
     */
    protected $active = true;

    /**
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $requisicao;

    /**
     * @return string
     */
    public function getRequisicao()
    {
        return $this->requisicao;
    }

    /**
     * @param string $requisicao
     */
    public function setRequisicao($requisicao)
    {
        $this->requisicao = $requisicao;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
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

}