<?php

namespace models\bll;

class ExercicioBLL extends BaseBLL
{
    public function __construct()
    {
        $this->nomeEntidade = 'models\entidades\Exercicio';
        parent::__construct();
    }
}