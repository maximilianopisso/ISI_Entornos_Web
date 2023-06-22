<?php

class Utils
{
    public static function alert($msj)
    {
        echo '<script>alert("' . $msj . '");</script>';
    }

    public static function obtenerMensajeExcepcion($mensajeCompleto)
    {
        $posicionExcepcion = strpos($mensajeCompleto, 'Exception: ');
        if ($posicionExcepcion !== false) {
            $posicionDosPuntos = strpos($mensajeCompleto, ':', $posicionExcepcion);
            $posicionPunto = strpos($mensajeCompleto, '.', $posicionExcepcion);
            if ($posicionDosPuntos !== false && $posicionPunto !== false) {
                $posicionInicio = $posicionDosPuntos + 1;
                $mensajeExcepcion = substr($mensajeCompleto, $posicionInicio, $posicionPunto - $posicionInicio + 1);
                return trim($mensajeExcepcion);
            }
        }
        return $mensajeCompleto;
    }
}
