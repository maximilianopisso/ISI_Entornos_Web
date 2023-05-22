<?php

class Movimiento
{
    private $fecha;
    private $nroCuenta;
    private $nroTransaccion;
    private $descripcion;
    private $importe;
    private $saldo;

    public function __construct($nroCuenta, $descripcion, $importe, $saldo)
    {

        $this->fecha = date('d/m/Y'); // Inicializar con la fecha actual
        $this->nroTransaccion = $this->generarNumeroTransaccion();
        $this->nroCuenta = $nroCuenta;
        $this->descripcion = $descripcion;
        $this->importe = $importe;
        $this->saldo = $saldo;
    }

    public function guardar()
    {
        // Implementar la lógica para guardar el movimiento en la base de datos
        // o realizar cualquier otra acción necesaria para llevar un registro de los movimientos.
    }

    private function generarNumeroTransaccion()
    {
        $timestamp = microtime(true);
        $identificador = str_replace('.', '', $timestamp);
        // $identificador = uniqid(); // Generar un identificador único
        // $numeroTransaccion = substr($identificador, 0, 10); // Obtener los primeros 10 caracteres

        return $identificador;

        // $fechaNumero = date('YmdHis'); // Obtener la fecha actual en formato numérico (ejemplo: 20230521101425)
        // $numeroAleatorio = rand(100, 999); // Generar un número aleatorio de tres dígitos
        // $numeroTransaccion = $fechaNumero . $numeroAleatorio;
        // return $numeroTransaccion;
    }
}
