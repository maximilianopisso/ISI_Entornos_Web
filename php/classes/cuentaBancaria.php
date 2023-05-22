<?php

class CuentaBancaria
{
    private $nroCuenta;
    private $tipoCuenta;
    private $tipoMoneda;
    private $nroCbu;
    private $alias;
    private $saldo;

    public function __construct($nroCuenta, $tipoCuenta, $tipoMoneda, $nroCbu, $alias, $saldo)
    {
        $this->nroCuenta = $nroCuenta;
        $this->tipoCuenta = $tipoCuenta;
        $this->tipoMoneda = $tipoMoneda;
        $this->nroCbu = $nroCbu;
        $this->alias = $alias;
        $this->saldo = $saldo;
    }

    //GETTERS
    public function getNroCuenta()
    {
        return $this->nroCuenta;
    }

    public function setNroCuenta($nroCuenta)
    {
        $this->nroCuenta = $nroCuenta;
    }

    public function getTipoCuenta()
    {
        return $this->tipoCuenta;
    }

    //SETTERS
    public function setTipoCuenta($tipoCuenta)
    {
        $this->tipoCuenta = $tipoCuenta;
    }

    public function getTipoMoneda()
    {
        return $this->tipoMoneda;
    }

    public function setTipoMoneda($tipoMoneda)
    {
        $this->tipoMoneda = $tipoMoneda;
    }

    public function getNroCbu()
    {
        return $this->nroCbu;
    }

    public function setNroCbu($nroCbu)
    {
        $this->nroCbu = $nroCbu;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    public function getSaldo()
    {
        return $this->saldo;
    }

    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;
    }

    //METODOS PERSONALIZADOS

    public function transferir(CuentaBancaria $cuentaDestino, $importe)
    {
        // Verifica si las cuentas tienen el mismo tipo de moneda
        if ($this->tipoMoneda !== $cuentaDestino->getTipoMoneda()) {
            throw new Exception("Las cuentas no tienen la misma moneda.");
        }

        // Verifica si la cuenta origen tiene suficiente saldo
        if ($this->saldo < $importe) {
            throw new Exception("Saldo insuficiente en la cuenta origen.");
        }

        // Restar el importe de la cuenta origen
        $this->saldo -= $importe;

        // Sumar el importe a la cuenta destino
        $cuentaDestino->sumarSaldo($importe);

        // Registrar el movimiento en ambas cuentas
        $this->registrarMovimiento(-$importe, "Transferencia a cuenta {$cuentaDestino->getNroCuenta()}");
        $cuentaDestino->registrarMovimiento($importe, "Transferencia desde cuenta {$this->getNroCuenta()}");
    }

    private function sumarSaldo($importe)
    {
        $this->saldo += $importe;
    }

    private function registrarMovimiento($importe, $descripcion)
    {
        $movimiento = new Movimiento($this->nroCuenta, $descripcion, $importe, $this->saldo);
        $movimiento->guardar(); // Aquí se invoca un método para guardar el movimiento en la base de datos o realizar otras acciones necesarias.
    }

    // ...
}
