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

    public function __construct($idOrigen, $idDestino, $descripcion, $importe, $saldo)
    {
        date_default_timezone_set('UTC'); // Establece la zona horaria a UTC
        $timezone_offset = -3 * 60 * 60; // Offset de GMT-3 en segundos (3 horas)
        $this->fecha =        gmdate("Y-m-d H:i:s", time() + $timezone_offset);
        $this->nroTransaccion = $this->generarNumeroTransaccion();
        $this->idOrigen = $idOrigen;
        $this->idDestino = $idDestino;
        $this->descripcion = $descripcion;
        $this->importe = $importe;
        $this->saldo = $saldo;
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

    public function registrarMovimiento()
    {
        try {
            $database = new Database();
            $query = "INSERT INTO movimientos (`mov_id`, `mov_cuenta_origen_id`, `mov_cuenta_destino_id`, `mov_fecha`, `mov_nro_transaccion`, `mov_descripcion`, `mov_importe`, `mov_saldo`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
            $resultado = $database->executeInsertQuery($query, [$this->idOrigen, $this->idDestino, $this->fecha, $this->nroTransaccion, $this->descripcion, $this->importe, $this->saldo]);
            if (!$resultado[0]) {
                return $resultado[0];
            } else {
                throw new Exception("No se pudo registrar el movimiento", 1);
            }
        } catch (Exception $e) {
            throw new Exception($e, $e->getCode());
        }
    }
}
