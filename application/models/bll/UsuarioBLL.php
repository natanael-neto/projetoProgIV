<?php

namespace models\bll;

class UsuarioBLL extends BaseBLL
{
    public function __construct()
    {
        $this->nomeEntidade = 'models\entidades\Usuario';
        parent::__construct();
    }
}
