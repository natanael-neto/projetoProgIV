<?php

namespace models\bll;

class ProfissionalBLL extends BaseBLL
{
    public function __construct()
    {
        $this->nomeEntidade = 'models\entidades\Profissional';
        parent::__construct();
    }
}
