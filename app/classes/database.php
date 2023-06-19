<?php
require_once './app/classes/cuenta.php';
class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "ibwallet";
    private $conexion;

    public function __construct()
    {
        try {
            $this->conexion = new mysqli($this->host, $this->username, $this->password, $this->database);
            $this->conexion->set_charset('utf8mb4');

            if ($this->conexion->connect_error) {
                throw new Exception($this->conexion->connect_error);
            }

            // Habilitar el modo de autocommit
            $this->conexion->autocommit(false);
        } catch (Exception $e) {
            throw new Exception($e, $e->getCode());
        }
    }

    public function beginTransaction()
    {
        $this->conexion->begin_transaction();
    }

    public function commit()
    {
        $this->conexion->commit();
        // $this->conexion->autocommit(true);
    }

    public function rollback()
    {
        $this->conexion->rollback();
        // $this->conexion->autocommit(true);
    }
    /**
     * Método que devuelve el tipo de dato que se pasa por parametro.
     */
    private function getTypeData($params)
    {
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } elseif (is_string($param)) {
                $types .= 's';
            } else {
                $types .= 'b';
            }
        }
        return $types;
    }

    /***
     * Método que ejecuta un SELECT de la query y sus parametros, que son enviados como argumentos.
     */
    public function executeSelectQuery($query, $params = [])
    {
        $filasAfectadas = 0;
        $data = [];

        try {
            $sentencia = $this->conexion->prepare($query);

            if (!$sentencia) {
                throw new Exception($this->conexion->error);
            }

            // En caso que la consulta contenga parametros, se preparan
            if (!empty($params)) {
                $tipoDatos = $this->getTypeData($params);
                $sentencia->bind_param($tipoDatos, ...$params);
            }

            // Ejecuta la sentencia SQL
            if (!$sentencia->execute()) {
                throw new Exception($this->conexion->error);
            }

            // Obtengo resultados
            $resultado = $sentencia->get_result();
            $filasAfectadas = $sentencia->affected_rows;
            $data = $resultado->fetch_all(MYSQLI_ASSOC);

            // Cierro sentencia y conexion con BD
            $sentencia->close();
            $this->conexion->close();

            //Se devuelve el resultado, y el numero de filas afectadas.
            return array($data, $filasAfectadas);
        } catch (Exception $e) {
            if ($sentencia) {
                $sentencia->close();
            }
            if ($this->conexion) {
                $this->conexion->close();
            }
            throw new Exception("Falla al ejecutar la sentencia SELECT", $e->getCode());
        }
    }

    /***
     * Método que ejecuta un UPDATE de la query y sus parametros, que son enviados como argumentos.
     */
    public function executeUpdateQuery($query, $params = [])
    {


        // try {
        //     $sentencia = $this->conexion->prepare($query);

        //     if (!$sentencia) {
        //         throw new Exception($this->conexion->error);
        //     }

        //     // En caso que la consulta contenga parametros, se preparan
        //     if (!empty($params)) {
        //         $tipoDatos = $this->getTypeData($params);
        //         $sentencia->bind_param($tipoDatos, ...$params);
        //     }

        //     // Ejecuta la sentencia SQL
        //     if (!$sentencia->execute()) {
        //         throw new Exception($this->conexion->error);
        //     }

        //     // Obtengo resultados 
        //     $resultado = $sentencia->get_result();
        //     $filasAfectadas = $sentencia->affected_rows;

        //     // Cierro sentencia y conecxion con BD
        //     $sentencia->close();
        //     $this->conexion->close();

        //     //Se devuelve el resultado, y el numero de filas afectadas.
        //     return array($resultado, $filasAfectadas);
        // } catch (Exception $e) {
        //     if ($sentencia) {
        //         $sentencia->close();
        //     }
        //     if ($this->conexion) {
        //         $this->conexion->close();
        //     }
        //     throw new Exception("Falla al ejecutar la sentencia UPDATE", $e->getCode());
        // }

        $filasAfectadas = 0;

        try {
            // Inicia una transacción
            $this->conexion->begin_transaction();

            $sentencia = $this->conexion->prepare($query);

            if (!$sentencia) {
                throw new Exception($this->conexion->error);
            }

            // En caso que la consulta contenga parametros, se preparan
            if (!empty($params)) {
                $tipoDatos = $this->getTypeData($params);
                $sentencia->bind_param($tipoDatos, ...$params);
            }

            // Ejecuta la sentencia SQL
            if (!$sentencia->execute()) {
                throw new Exception($this->conexion->error);
            }

            // Obtengo resultados 
            $resultado = $sentencia->get_result();
            $filasAfectadas = $sentencia->affected_rows;

            // Confirma la transacción
            $this->conexion->commit();

            // Cierro sentencia y conexión con BD
            $sentencia->close();
            $this->conexion->close();

            // Se devuelve el resultado y el número de filas afectadas
            return array($resultado, $filasAfectadas);
        } catch (Exception $e) {
            // Realiza un rollback en caso de error
            $this->conexion->rollback();

            if ($sentencia) {
                $sentencia->close();
            }
            if ($this->conexion) {
                $this->conexion->close();
            }
            throw new Exception("Falla al ejecutar la sentencia UPDATE", $e->getCode());
        }
    }

    /***
     * Método que ejecuta un INSERT de la query y sus parametros, que son enviados como argumentos.
     */
    public function executeInsertQuery($query, $params = [])
    {
        $filasAfectadas = 0;

        try {
            // Inicia una transacción
            $this->conexion->begin_transaction();

            $sentencia = $this->conexion->prepare($query);

            if (!$sentencia) {
                throw new Exception($this->conexion->error);
            }

            // En caso que la consulta contenga parametros, se preparan
            if (!empty($params)) {
                $tipoDatos = $this->getTypeData($params);
                $sentencia->bind_param($tipoDatos, ...$params);
            }

            // Ejecuta la sentencia SQL
            if (!$sentencia->execute()) {
                throw new Exception($this->conexion->error);
            }

            // Obtengo resultados
            $resultado = $sentencia->get_result();
            $filasAfectadas = $sentencia->affected_rows;

            // Confirma la transacción
            $this->conexion->commit();

            // Cierro sentencia y conexión con BD
            $sentencia->close();
            $this->conexion->close();

            // Se devuelve el resultado y el número de filas afectadas
            return array($resultado, $filasAfectadas);
        } catch (Exception $e) {
            // Realiza un rollback en caso de error
            $this->conexion->rollback();

            if ($sentencia) {
                $sentencia->close();
            }
            if ($this->conexion) {
                $this->conexion->close();
            }
            throw new Exception("Falla al ejecutar la sentencia INSERT", $e->getCode());
        }
    }


    public function getUsuarioByEmail($email)
    {
        $query = "SELECT * FROM usuarios WHERE user_email = ?";
        try {
            $resultado = $this->executeSelectQuery($query, [$email]);
            if ($resultado[1] !== 0) {
                return $resultado[0];
            } else {
                return false;
            };
        } catch (Exception $e) {
            throw new Exception("Falla al obtener usuario por email conocido", $e->getCode());
        }
    }

    public function getUsuarioById($user_id)
    {
        $query = "SELECT * FROM usuarios WHERE user_id = ?";
        try {
            $resultado = $this->executeSelectQuery($query, [$user_id]);
            if ($resultado[1] !== 0) {
                return $resultado[0];
            } else {
                return false;
            };
        } catch (Exception $e) {
            throw new Exception("Falla al obtener usuario por id conocido", $e->getCode());
        }
    }
    public function getCuentabyNroCuenta($nroCuenta)
    {
        $query = "SELECT * FROM cuentas WHERE cue_nro_cuenta = ?";
        try {
            $resultado = $this->executeSelectQuery($query, [$nroCuenta]);
            if ($resultado[1] !== 0) {
                return $resultado[0];
            } else {
                return false;
            };
        } catch (Exception $e) {
            throw new Exception("Falla al obtener cuenta por numero de cuenta conocido", $e->getCode());
        }
    }

    public function existeUsuario($email)
    {
        $query = "SELECT * FROM usuarios WHERE user_email = ?";
        try {
            $resultado = $this->executeSelectQuery($query, [$email]);
            if ($resultado[1] !== 0) {
                return true;
            } else {
                return false;
            };
        } catch (Exception $e) {
            throw new Exception("Falla al verificar existencia de usuario por email conocido", $e->getCode());
        }
    }

    public function registrarTransaccion(Cuenta $cuentaOrigen, Cuenta $cuentaDestino, $importe)
    {
        try {
            // Verifica si las cuentas tienen el mismo tipo de moneda
            $monedaCuentaOrigen = $cuentaDestino->getTipoMoneda();
            $monedaCuentaDestino = $cuentaDestino->getTipoMoneda();

            if ($monedaCuentaOrigen !== $monedaCuentaDestino) {
                throw new Exception("Las cuentas seleccionadas deben tener la misma moneda.");
            }

            // Verifica que el importe sea > a 0
            if ($importe < 0) {
                throw new Exception("El importe deber ser superior a $0.00");
            }

            // Verifica si la cuenta origen tiene suficiente saldo
            $saldoOringen = $cuentaOrigen->getSaldo();
            if ($saldoOringen < $importe) {
                throw new Exception("El saldo de la cuenta de origen es insuficiente.");
            }

            // Resta el importe a transferir desde la cuenta origen
            $saldoOringen -= $importe;

            // Suma el importe a la cuenta destino, transferido a desde la cuenta origen.
            $cuentaDestino->sumarSaldo($importe);

            // Inicia una transacción
            $this->beginTransaction();

            // Ejecución de la primera consulta
            $database = new Database();
            $query = "UPDATE cuentas SET cue_saldo = ? WHERE cue_id = ?";
            $resultado = $database->executeUpdateQuery($query, [$this->saldo, $this->id]);
            if ($resultado[1] !== 0) {
                return true;
            } else {
                return false;
            };
            $query1 = "INSERT INTO tabla1 (columna1, columna2) VALUES (?, ?)";
            $resultado1 = $this->conexion->executeInsertQuery($query1, $params1);

            // Verifica el resultado de la primera consulta
            if ($resultado1[1] === 0) {
                throw new Exception("Fallo en la consulta 1");
            }

            // Ejecución de la segunda consulta
            $query2 = "UPDATE tabla2 SET columna1 = ? WHERE id = ?";
            $params2 = [valor3, valor4];
            $resultado2 = $database->executeUpdateQuery($query2, $params2);

            // Verifica el resultado de la segunda consulta
            if ($resultado2[1] === 0) {
                throw new Exception("Fallo en la consulta 2");
            }

            // Ejecución de la tercera consulta
            $query3 = "DELETE FROM tabla3 WHERE id = ?";
            $params3 = [valor5];
            $resultado3 = $database->executeDeleteQuery($query3, $params3);

            // Verifica el resultado de la tercera consulta
            if ($resultado3[1] === 0) {
                throw new Exception("Fallo en la consulta 3");
            }

            // Ejecución de la cuarta consulta
            $query4 = "INSERT INTO tabla4 (columna1) VALUES (?)";
            $params4 = [valor6];
            $resultado4 = $database->executeInsertQuery($query4, $params4);

            // Verifica el resultado de la cuarta consulta
            if ($resultado4[1] === 0) {
                throw new Exception("Fallo en la consulta 4");
            }

            // Si todas las consultas se ejecutaron correctamente, se realiza el commit
            $database->commit();

            // Se cierra la conexión con la base de datos
            $database->closeConnection();

            // Realizar cualquier otra acción después de las consultas exitosas

        } catch (Exception $e) {
            // Si hubo algún error, se realiza el rollback
            $database->rollback();

            // Se cierra la conexión con la base de datos
            $database->closeConnection();

            // Manejo del error
            echo "Error: " . $e->getMessage();
        }
    }
}
