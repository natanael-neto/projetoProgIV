<?php

namespace models\BLL;

class PessoaBLL extends BaseBLL
{
    public function __construct()
    {
        $this->nomeEntidade = 'models\entidades\Pessoa';
        parent::__construct();
    }
}
