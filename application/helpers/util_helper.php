<?php

function perfilUsuario($login = null)
{
    if ($login) {
        $usuarioBLL = new \models\bll\UsuarioBLL();
        $usuario = $usuarioBLL->buscarUmPor(array('login' => $login));

        return $usuario->getPerfil()->getNome();
    }
}

function validaEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validaCpf($cpf)
{
    // Extrai somente os números
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

function validaDataNascimento($data)
{
    // Quebra a data em dia, mês e ano respectivamente.
    $datas = explode('/', $data);

    if (checkdate($datas[1], $datas[0], $datas[2])) {
        return true;
    } else {
        return false;
    }
}


function dataStrToObject($dataHora)
{
    $dataHora = \trim($dataHora);

    if (empty($dataHora)) {
        return null;
    } else {
        list($dia, $mes, $ano) = explode("/", $dataHora);
        $dataFormatada = $ano . '-' . $mes . '-' . $dia;

        if (strlen($dataHora) > 10) { //Data com hora
            list($ano, $hora) = explode(" ", $ano);
            $dataFormatada = $ano . '-' . $mes . '-' . $dia . ' ' . $hora;
        }

        try {
            return new \DateTime($dataFormatada);
        } catch (\Exception $ex) {
            throw new \Exception("A data \"$dataHora\" é inválida.");
        }
    }
}

function dataObjToBanco($dataHora)
{
    if (empty($dataHora)) {
        return "";
    } else {
        return $dataHora->format('Y-m-d') . " 23:59:59";
    }
}

function dataObjectToStr(DateTime $dateTime, $comHora = false)
{
    $strDate = $dateTime->format("d/m/Y");
    if ($comHora) {
        $strDate .= $dateTime->format(" H:i:s");
    }

    return $strDate;
}
