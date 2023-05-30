<?php
require_once 'database.php';
require_once 'movimiento.php';
require_once 'utils.php';
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

    public function getAlias()
    {
        return $this->alias;
    }
    public function setNroCbu($nroCbu)
    {
        $this->nroCbu = $nroCbu;
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
            throw new Exception($e, $e->getCode());
        } finally {
            // Cerrar la conexión a la base de datos
            $database->closeDatabase();
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
            throw new Exception($e, $e->getCode());
        } finally {
            // Cerrar la conexión a la base de datos
            $database->closeDatabase();
        }
    }

    public function transferirImporte(Cuenta $cuentaDestino, $importe)
    {
        try {
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
            $cuentaDestino->sumarSaldo($importe);
            $updateCuentaOrigen = $this->actualizarSaldo();
            if (!$updateCuentaOrigen) {
                Utils::alert("update saldo cuenta origen ");
            } else {
                Utils::alert("Error en el update cuenta origen ");
            }
            $updateCuentaDestino = $cuentaDestino->actualizarSaldo();
            if (!$updateCuentaDestino) {
                Utils::alert("update saldo cuenta destino ");
            } else {
                Utils::alert("Error en el update cuenta destino ");
            }


            // Registrar el movimiento en ambas cuentas
            //Registro mov cuenta origen
            $regMovOrigen = $this->registrarMovimiento($cuentaDestino->getId(), "Transferencia de dinero", $importe);
            if (!$regMovOrigen) {
                Utils::alert("Se registra movimiento para la cuenta origen");
            } else {
                Utils::alert("Error registro movimiento cuenta origen");
            }
            //Regitro mov cuenta destino
            $regMovDetino = $cuentaDestino->registrarMovimiento($this->id, "Ingreso de dinero", $importe);
            if (!$regMovDetino) {
                Utils::alert("Se registra movimiento para la cuenta destino");
            } else {
                Utils::alert("Error registro movimiento cuenta destino");
            }
        } catch (Exception $e) {
            throw new Exception($e, 1);
        }
    }

    private function sumarSaldo($importe)
    {
        $this->saldo += $importe;
    }

    private function registrarMovimiento($idDestino, $descripcion, $importe)
    {
        try {
            $movimiento = new Movimiento($this->id, $idDestino, $descripcion, $importe, $this->saldo);
            $resultado = $movimiento->registrarMovimiento();
            if (!$resultado) {
                return $resultado;
            } else {
                throw new Exception("No se pudo registrar el movimiento", 1);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function actualizarSaldo()
    {
        try {
            $query = "UPDATE cuentas SET cue_saldo = ? WHERE cue_id = ?";
            $database = new Database();
            $resultado = $database->executeUpdateQuery($query, [$this->saldo, $this->id]);
            if ($resultado[1] !== 0) {
                return $resultado[0];
            } else {
                return false;
            };
        } catch (Exception $e) {
            throw new Exception($e, $e->getCode());
        } finally {
            // Cerrar la conexión a la base de datos
            $database->closeDatabase();
        }
    }
}
