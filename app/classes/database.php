<?php

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
        } catch (Exception $e) {
            throw new Exception($e, $e->getCode());
        }
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
            throw new Exception("Falla al ejecutar la sentencia SELECT", $e->getCode());
        }
    }

    /***
     * Método que ejecuta un UPDATE de la query y sus parametros, que son enviados como argumentos.
     */
    public function executeUpdateQuery($query, $params = [])
    {
        $filasAfectadas = 0;

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

            // Cierro sentencia y conecxion con BD
            $sentencia->close();
            $this->conexion->close();

            //Se devuelve el resultado, y el numero de filas afectadas.
            return array($resultado, $filasAfectadas);
        } catch (Exception $e) {
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

            // Cierro sentencia y conecxion con BD
            $sentencia->close();
            $this->conexion->close();

            //Se devuelve el resultado, y el numero de filas afectadas.
            return array($resultado, $filasAfectadas);
        } catch (Exception $e) {
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
}
