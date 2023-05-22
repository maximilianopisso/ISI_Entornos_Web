<?php

class Usuario
{
    private $nombre;
    private $apellido;
    private $email;
    private $password;
    private $contacto;
    private $sexo;
    private $cuentas;
    private $movimientos;
    private $nroIntentos;
    private $habilitado;

    public function __construct($id, $nombre, $apellido, $email, $password, $contacto, $sexo)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->password = $password;
        $this->contacto = $contacto;
        $this->sexo = $sexo;
        // $this->cuentas = []; // Inicializar el saldo en 0
        // $this->movimientos = [];
        $this->nroIntentos = 3;
        $this->habilitado = true;
    }

    // GETTERS
    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->email;
    }

    public function getContacto()
    {
        return $this->contacto;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    public function getCuentas()
    {
        return $this->cuentas;
    }

    public function getMovimientos()
    {
        return $this->movimientos;
    }

    public function getNroIntentos()
    {
        return $this->nroIntentos;
    }

    public function getHabilitado()
    {
        return $this->habilitado;
    }

    // SETTERS
    // public function setCuentas($cuentas)
    // {
    //     $this->cuentas = $cuentas;
    // }

    // public function setMovimientos($movimientos)
    // {
    //     $this->cuentas = $movimientos;
    // }

    // METODOS PERSONALIZADOS
    public function resetNroIntentos()
    {
        $this->nroIntentos = 3;
    }

    public function restarNroIntentos()
    {
        if ($this->nroIntentos === 0) {
            return false;
        } else {
            $this->nroIntentos--;
            return true;
        }
    }

    public function inhabilitar()
    {
        $this->habilitado = false;
    }









    public function agregarMovimiento($tipo, $monto)
    {
        $movimiento = [
            "tipo" => $tipo,
            "monto" => $monto,
            "fecha" => date("Y-m-d H:i:s")
        ];
        $this->movimientos[] = $movimiento;
    }

    public function visualizarMovimientos()
    {
        foreach ($this->movimientos as $movimiento) {
            echo "Tipo: " . $movimiento['tipo'] . ", Monto: " . $movimiento['monto'] . ", Fecha: " . $movimiento['fecha'] . "<br>";
        }
    }
}
