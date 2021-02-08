<?php
/**
 * Created by PhpStorm.
 * User: pauloslash
 * Date: 10/03/2020
 * Time: 15:33
 */

namespace models\entidades;


/**
 * @Entity @Table(name="prospeccao_estagio")
 * */
class ProspeccaoEstagio extends Entidade {
    /**
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $nome;

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
}
