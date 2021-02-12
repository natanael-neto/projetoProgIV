<?php

namespace models\bll;

class AgendamentoBLL extends BaseBLL
{
    public function __construct()
    {
        $this->nomeEntidade = 'models\entidades\Agendamento';
        parent::__construct();
    }
}
