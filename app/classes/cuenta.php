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

    private function sumarSaldo($importe)
    {
        $this->saldo += $importe;
    }

    private function registrarMovimiento($idDestino, $descripcion, $importe)
    {
        try {
            $movimiento = new Movimiento($this->id, $idDestino, $descripcion, $importe, $this->saldo);
            $resultado = $movimiento->registrarMovimiento();
            if ($resultado) {
                return true;
            } else {
                throw new Exception("Falla en el registro del nuevo movimiento");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function transferirImporte(Cuenta $cuentaDestino, $importe)
    {
        try {
            // Verifica si las cuentas tienen el mismo tipo de moneda
            if ($this->tipoMoneda !== $cuentaDestino->getTipoMoneda()) {
                throw new Exception("Las cuentas seleccionadas deben tener la misma moneda.");
            }

            // Verifica que el importe sea > a 0
            if ($importe < 0) {
                throw new Exception("El importe deber ser superior a $0.00");
            }

            // Verifica si la cuenta origen tiene suficiente saldo
            if ($this->saldo < $importe) {
                throw new Exception("El saldo de la cuenta de origen es insuficiente.");
            }

            // Resta el importe a transferir desde la cuenta origen
            $this->saldo -= $importe;

            // Suma el importe a la cuenta destino, transferido a desde la cuenta origen.
            $cuentaDestino->sumarSaldo($importe);

            // Actualiza saldo en BD de la cuenta origen.
            $updateCuentaOrigen = $this->actualizarSaldo();
            if ($updateCuentaOrigen === false) {
                throw new Exception("No se pudo efectuar la actualizacion del saldo en la cuenta origen");
            }

            // Actualiza saldo en BD de la cuenta destino.
            $updateCuentaDestino = $cuentaDestino->actualizarSaldo();
            if ($updateCuentaDestino === false) {
                throw new Exception("No se pudo efectuar la actualizacion del saldo en la cuenta destino");
            }

            //Registro nuevo movimiento en cuenta origen
            $regMovOrigen = $this->registrarMovimiento($cuentaDestino->getId(), "Transferencia de dinero", $importe);
            if ($regMovOrigen === false) {
                throw new Exception("No se pudo registrar el movimiento en la cuenta origen");
            }

            //Registro nuevo movimiento en cuenta destino
            $regMovDetino = $cuentaDestino->registrarMovimiento($this->id, "Ingreso de dinero", $importe);
            if ($regMovDetino === false) {
                throw new Exception("No se pudo registrar el movimiento en la cuenta destino");
            }
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
            // throw new Exception("Falla en el registro de los movimientos entre cuentas", $e->getCode());
        }
    }
}

// ASI DEBERIA SER !! POR LO MENOS PARA ESTE CASO !! PARA PODER HACER ROLLBACK EN CASO QUE FALLE ALGUNA
// try {
//     // Iniciar transacción
//     $this->conexion->begin_transaction();

//     // Ejecutar consulta 1
//     $query1 = "UPDATE tabla1 SET columna1 = 'valor1' WHERE id = 1";
//     $resultado1 = $this->conexion->query($query1);
//     if ($resultado1 === false) {
//         throw new Exception($this->conexion->error);
//     }

//     // Ejecutar consulta 2
//     $query2 = "UPDATE tabla2 SET columna2 = 'valor2' WHERE id = 2";
//     $resultado2 = $this->conexion->query($query2);
//     if ($resultado2 === false) {
//         throw new Exception($this->conexion->error);
//     }

//     // Confirmar la transacción
//     $this->conexion->commit();

//     // Realizar otras acciones después de la confirmación
// } catch (Exception $e) {
//     // En caso de error, deshacer la transacción
//     $this->conexion->rollback();

//     // Manejar el error
//     throw $e; // Relanzar la excepción para que sea manejada en otro nivel
// }