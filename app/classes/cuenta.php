<?php
require_once 'database.php';
require_once 'movimiento.php';

class Cuenta
{
    private $id;
    private $user_id;
    private $nroCuenta;
    private $tipoCuenta;
    private $tipoMoneda;
    private $nroCbu;
    private $alias;
    private $saldo;

    public function __construct($id, $user_id, $nroCuenta, $tipoCuenta, $tipoMoneda, $nroCbu, $alias, $saldo)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->nroCuenta = $nroCuenta;
        $this->tipoCuenta = $tipoCuenta;
        $this->tipoMoneda = $tipoMoneda;
        $this->nroCbu = $nroCbu;
        $this->alias = $alias;
        $this->saldo = $saldo;
    }

    //GETTERS
    public function getId()
    {
        return $this->id;
    }

    public function getTipoMoneda()
    {
        return $this->tipoMoneda;
    }

    public function getSaldo()
    {
        return $this->saldo;
    }

    public function sumarSaldo($importe)
    {
        $this->saldo += $importe;
    }

    //METODOS
    public function getCuentabyNroCuenta($nroCuenta)
    {
        $database = new Database();
        $query = "SELECT * FROM cuentas WHERE cue_nro_cuenta = ?";
        try {
            $resultado = $database->executeSelectQuery($query, [$nroCuenta]);
            if ($resultado[1] !== 0) {
                return $resultado[0];
            } else {
                return false;
            };
        } catch (Exception $e) {
            throw new Exception("Falla en la conexión con la base de datos", $e->getCode());
        }
    }

    public function obtenerMovimientos()
    {
        try {
            $query = "SELECT * FROM movimientos WHERE mov_cuenta_origen_id = ? ORDER by mov_fecha DESC";
            $database = new Database();
            $resultado = $database->executeSelectQuery($query, [$this->id]);
            if ($resultado[1] !== 0) {
                return $resultado[0];
            } else {
                return false;
            };
        } catch (Exception $e) {
            throw new Exception("Falla en la conexión con la base de datos", $e->getCode());
        }
    }

    public function actualizarSaldo()
    {
        try {
            $query = "UPDATE cuentas SET cue_saldo = ? WHERE cue_id = ?";
            $database = new Database();
            $resultado = $database->executeUpdateQuery($query, [$this->saldo, $this->id]);
            if ($resultado[1] !== 0) {
                return true;
            } else {
                return false;
            };
        } catch (Exception $e) {
            throw new Exception("Falla en la conexión con la base de datos", $e->getCode());
        }
    }

    public function registrarTransacccion(Cuenta $cuentaDestino, $importe)
    {
        try {
            //Verifica y formatea el importe
            if (is_numeric($importe)) {
                $importe = floatval($importe);
                $importe = round($importe, 2);
            } else {
                throw new Exception("El importe ingresado no posee un formato válido.");
            }

            // Verifica si las cuentas tienen el mismo tipo de moneda
            if ($this->tipoMoneda !== $cuentaDestino->getTipoMoneda()) {
                throw new Exception("Las cuentas seleccionadas deben tener la misma moneda.");
            }

            // Verifica que el importe sea > a 0
            if ($importe <= 0) {
                throw new Exception("El importe deber ser superior a $0.00.");
            }

            // Verifica si la cuenta origen tiene suficiente saldo
            if ($this->saldo < $importe) {
                throw new Exception("El saldo de la cuenta de origen es insuficiente.");
            }

            // Resta el importe a transferir desde la cuenta origen
            $this->saldo -= $importe;

            // Suma el importe a la cuenta destino, transferido a desde la cuenta origen.
            $cuentaDestino->sumarSaldo($importe);

            //Registra operacion en base de datos
            $database = new Database();
            $database->registrarOperacion($this->id, $this->saldo, $cuentaDestino, $importe);
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
