<?php

namespace models\entidades;

/**
 * @Entity @Table(name="usuario")
 * */
class Usuario extends Entidade
{
    /**
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $nome;

    /**
     * @ManyToOne(targetEntity="Perfil")
     */
    protected $perfil;

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
     * @return Perfil
     */
    public function getPerfil()
    {
        return $this->perfil;
    }

    /**
     * @param Perfil $perfil
     */
    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;
    }
}
