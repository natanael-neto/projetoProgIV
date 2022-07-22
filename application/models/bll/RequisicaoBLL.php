<?php

namespace models\bll;

class RequisicaoBLL extends BaseBLL
{
    public function __construct()
    {
        $this->nomeEntidade = 'models\entidades\Requisicao';
        parent::__construct();
    }
}