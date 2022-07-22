<?php

namespace models\bll;

class MedidaBLL extends BaseBLL
{
    public function __construct()
    {
        $this->nomeEntidade = 'models\entidades\Medida';
        parent::__construct();
    }
}