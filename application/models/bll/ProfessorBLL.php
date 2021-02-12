<?php

namespace models\bll;

class ProfessorBLL extends BaseBLL
{
    public function __construct()
    {
        $this->nomeEntidade = 'models\entidades\Professor';
        parent::__construct();
    }
}
