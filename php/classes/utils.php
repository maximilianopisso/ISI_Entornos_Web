<?php

class Utils
{
    public static function screenMsj($msj)
    {
        echo "<hr>" . $msj . "<hr>";
    }

    public static function msjCodigoError($codigo, Exception $error)
    {
        $msj = 0;
        switch ($codigo) {
            case 100:
                $msj = "Falla en la conexión con BD: ";
                break;
            case 101:
                $msj = "Error de preparación de consulta: ";
                break;
            case 102:
                $msj = "Error en la ejecucion de la consulta: ";
                break;
            case 103:
                $msj = "Error Conexion BD: ";
                break;
            default:
                $msj = "Error Generico: ";
                break;
        }
        Utils::screenMsj($msj . $error->getMessage());
    }

    public static function mostrarUsuarios($usuarios)
    {
        foreach ($usuarios as $usuario) {
            Utils::screenMsj("id: " . $usuario["user_id"]);
            Utils::screenMsj("nombre: " . $usuario["user_nombre"]);
            Utils::screenMsj("apellido: " . $usuario["user_apellido"]);
            Utils::screenMsj("email: " . $usuario["user_email"]);
            Utils::screenMsj("password: " . $usuario["user_password"]);
            Utils::screenMsj("contacto: " . $usuario["user_contacto"]);
            Utils::screenMsj("sexo: " . $usuario["user_sexo"]);
            Utils::screenMsj("nroIntentos: " . $usuario["user_intentos"]);
            Utils::screenMsj("habilitado: " . $usuario["user_habilitado"]);
        }
    }

    public static function mostrarCuentas($cuentas)
    {
        foreach ($cuentas as $cuenta) {
            Utils::screenMsj("id: " . $cuenta["cue_id"]);
            Utils::screenMsj("user id: " . $cuenta["cue_user_id"]);
            Utils::screenMsj("nro cuenta: " . $cuenta["cue_nro_cuenta"]);
            Utils::screenMsj("tipo cuenta: " . $cuenta["cue_tipo_cuenta"]);
            Utils::screenMsj("tipo moneda: " . $cuenta["cue_tipo_moneda"]);
            Utils::screenMsj("cbu: " . $cuenta["cue_cbu"]);
            Utils::screenMsj("alias: " . $cuenta["cue_alias"]);
            Utils::screenMsj("saldos: " . $cuenta["cue_saldo"]);
        }
    }
    public static function alert($msj)
    {
        echo '<script>alert("' . $msj . '");</script>';
    }
}
