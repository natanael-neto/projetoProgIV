<?php

namespace models\bll;

class EnderecoBLL extends BaseBLL
{
    public function __construct()
    {
        $this->nomeEntidade = 'models\entidades\Endereco';
        parent::__construct();
    }
}
