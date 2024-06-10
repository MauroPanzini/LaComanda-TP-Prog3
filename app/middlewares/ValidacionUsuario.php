<?php

class ValidacionUsuario
{
    public static function validarUsuario($usuario)
    {
        // Verificar que el usuario no sea numérico
        if (is_numeric($usuario)) {
            return false;
        }

        return true;
    }

    public static function validarClave($clave)
    {
        // Verificar que la clave tenga menos de 8 caracteres
        if (strlen($clave) > 8) {
            return false;
        }

        return true;
    }
}
?>