<?php
/**
 * Created by PhpStorm.
 * User: pauloslash
 * Date: 10/03/2020
 * Time: 15:33
 */

namespace models\entidades;


/**
 * @Entity @Table(name="pessoa")
 * */
class Pessoa extends Entidade {
    /**
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $nome;

    /**
     * @var integer
     * @Column(type="integer", nullable=false)
     */
    protected $idade;

    /**
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome) {
        $this->nome = $nome;
    }

    /**
     * @return integer
     */
    public function getIdade() {
        return $this->idade;
    }

    /**
     * @param integer $idade
     */
    public function setIdade($idade) {
        $this->idade = $idade;
    }
}
