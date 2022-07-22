<?php

namespace models\entidades;

/**
 * @Entity @Table(name="exercicio")
 * */
class Exercicio extends Entidade
{
    /**
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $nome;

    /**
     * @ManyToOne(targetEntity="Categoria")
     */
    protected $categoria;

    /** 
     * @var Modalidade
     * @ManyToMany(targetEntity="Modalidade", inversedBy="exercicios")
     * @JoinTable(name="exercicios_modalidades",
     *      joinColumns={@JoinColumn(name="exercicio_id", referencedColumnName="id", unique=false)},
     *      inverseJoinColumns={@JoinColumn(name="modalidade_id", referencedColumnName="id", unique=false)}
     *      )
     */
    protected $modalidades;

    /**
     * @ManyToOne(targetEntity="Medida")
     */
    protected $medida;


    public function __construct(){
        parent::__construct();
        $this->modalidades = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Modalidade
     */
    public function getModalidades()
    {
        return $this->modalidades;
    }

    /**
     * @param Modalidade $modalidades
     */
    public function setModalidades($modalidades)
    {
        $this->modalidades = $modalidades;
    }

    /**
    * @return Categoria
    *
    */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
    * @param Categoria $categoria
    */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    /**
    * @return Medida
    */
    public function getMedida()
    {
        return $this->medida;
    }

    /**
     * @param Medida $medida
     */
    public function setMedida($medida)
    {
        $this->medida = $medida;
    }


}
