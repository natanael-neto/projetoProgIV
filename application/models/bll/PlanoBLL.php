<?php

namespace models\bll;

class PlanoBLL extends BaseBLL
{
    public function __construct()
    {
        $this->nomeEntidade = 'models\entidades\Plano';
        parent::__construct();
    }
}
