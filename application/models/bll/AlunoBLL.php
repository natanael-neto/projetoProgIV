<?php

namespace models\BLL;

class PessoaBLL extends BaseBLL
{
    public function __construct()
    {
        $this->nomeEntidade = 'models\entidades\Aluno';
        parent::__construct();
    }
}
