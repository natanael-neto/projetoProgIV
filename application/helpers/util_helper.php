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

function removerMaskmoney($valor)
{
    if (!is_null($valor)) {
        return floatval(trim(preg_replace(array('/[.]/', '/,/', '/ [^0-9]+/'), array('', '.', ''), str_replace('R$', '', $valor))));
    }

    return null;
}

function removerMask($valor)
{
    return trim(preg_replace(array('/[.]/', '/,/', '/ +/', '/\(/', '/\)/', '/-/', '/\//'), '', $valor));
}

function formatar_dinheiro($valor, $precision = 2, $dec_point = ',', $thousands_sep = '.')
{
    return 'R$ ' . number_format($valor, $precision, $dec_point, $thousands_sep);
}

function formatar_decimal($valor, $precision = 2)
{
    return number_format($valor, $precision, ',', '.');
}

function gerar_senha($tamanho = 8, $minusculas = true, $numeros = true, $maiusculas = false, $simbolos = false)
{
    $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
    $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
    $nu = "0123456789"; // $nu contem os números
    $si = "!@#$%¨&*()_+="; // $si contem os símbolos
    $senha = "";

    if ($maiusculas) {
        // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
        $senha .= str_shuffle($ma);
    }

    if ($minusculas) {
        // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
        $senha .= str_shuffle($mi);
    }

    if ($numeros) {
        // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
        $senha .= str_shuffle($nu);
    }

    if ($simbolos) {
        // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
        $senha .= str_shuffle($si);
    }

    // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
    return substr(str_shuffle($senha), 0, $tamanho);
}
