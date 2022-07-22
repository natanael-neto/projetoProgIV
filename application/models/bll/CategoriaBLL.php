<?php

namespace models\bll;

class CategoriaBLL extends BaseBLL
{
    public function __construct()
    {
        $this->nomeEntidade = 'models\entidades\Categoria';
        parent::__construct();
    }
}