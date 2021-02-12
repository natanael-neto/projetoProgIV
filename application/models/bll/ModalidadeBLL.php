<?php

namespace models\bll;

class ModalidadeBLL extends BaseBLL
{
    public function __construct()
    {
        $this->nomeEntidade = 'models\entidades\Modalidade';
        parent::__construct();
    }
}
