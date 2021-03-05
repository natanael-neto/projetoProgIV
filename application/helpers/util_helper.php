<?php

function perfilUsuario($login = null)
{
    if ($login) {
        $usuarioBLL = new \models\bll\UsuarioBLL();
        $usuario = $usuarioBLL->buscarUmPor(array('login' => $login));

        return $usuario->getPerfil()->getNome();
    }
}
