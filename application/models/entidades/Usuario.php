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
    protected $username;

    /**
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $login;

    /**
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $password;

    /**
     * @Column(type="boolean", nullable=false)
     */
    protected $active = true;

    /**
     * @ManyToOne(targetEntity="Perfil")
     */
    protected $perfil;

    /**
     * @OneToOne(targetEntity="Aluno", mappedBy="usuario")
     */
    private $aluno;

    /**
     * @OneToOne(targetEntity="Profissional", mappedBy="usuario")
     */
    private $profissional;

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
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

    /**
     * @return Aluno
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

    /**
     * @return Profissional
     */
    public function getProfissional()
    {
        return $this->profissional;
    }

    /**
     * @param Profissional $profissional
     */
    public function setProfissional($profissional)
    {
        $this->profissional = $profissional;
    }
}
