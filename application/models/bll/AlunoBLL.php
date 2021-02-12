<?php

namespace models\bll;

class AlunoBLL extends BaseBLL
{
    public function __construct()
    {
        $this->nomeEntidade = 'models\entidades\Aluno';
        parent::__construct();
    }
}
