<?php

require_once "database.php";

class Movimiento
{
    private $fecha;
    private $idOrigen;
    private $idDestino;
    private $nroTransaccion;
    private $descripcion;
    private $importe;
    private $saldo;

    /***
     * Método que proporciona un numero de transaccion único para el resgristro de movimientos.
     */
    private function generarNumeroTransaccion()
    {
        $timestamp = microtime(true);
        $identificador = str_replace('.', '', $timestamp);
        return $identificador;
    }

    public function __construct($idOrigen, $idDestino, $descripcion, $importe, $saldo)
    {
        date_default_timezone_set('UTC'); // Establece la zona horaria a UTC
        $timezone_offset = -3 * 60 * 60; // Offset de GMT-3 en segundos (3 horas)
        $this->fecha = gmdate("Y-m-d H:i:s", time() + $timezone_offset);
        $this->nroTransaccion = $this->generarNumeroTransaccion();
        $this->idOrigen = $idOrigen;
        $this->idDestino = $idDestino;
        $this->descripcion = $descripcion;
        $this->importe = $importe;
        $this->saldo = $saldo;
    }

    public function getInfoMovimiento()
    {
           return array($this->idOrigen, $this->idDestino, $this->fecha, $this->nroTransaccion, $this->descripcion, $this->importe, $this->saldo);
    }

    public function registrarMovimiento()
    {
        try {
            $database = new Database();
            $query = "INSERT INTO movimientos (`mov_id`, `mov_cuenta_origen_id`, `mov_cuenta_destino_id`, `mov_fecha`, `mov_nro_transaccion`, `mov_descripcion`, `mov_importe`, `mov_saldo`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
            $resultado = $database->executeInsertQuery($query, [$this->idOrigen, $this->idDestino, $this->fecha, $this->nroTransaccion, $this->descripcion, $this->importe, $this->saldo]);
            if ($resultado[1] !== 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception("Falla al registrar movimiento de cuenta", $e->getCode());
        }
    }
}
