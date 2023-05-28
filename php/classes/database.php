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
                throw new Exception($this->conexion->connect_error, 100);
            }
        } catch (Exception $e) {
            throw new Exception($e, $e->getCode());
        }
    }

    public function executeSelectQuery($query, $params = [])
    {
        $filasAfectadas = 0;
        $data = [];

        try {
            $sentencia = $this->conexion->prepare($query);

            if (!$sentencia) {
                throw new Exception($this->conexion->error, 101);
            }
            // En caso de tener parametros, se preparan los tipos de parametros
            if (!empty($params)) {
                $tipoDatos = $this->getTypeData($params);
                $sentencia->bind_param($tipoDatos, ...$params);
            }
            // Ejecuta la sentencia SQL
            if (!$sentencia->execute()) {
                throw new Exception($this->conexion->error, 102);
            }
            $resultado = $sentencia->get_result();
            $filasAfectadas = $sentencia->affected_rows;
            $data = $resultado->fetch_all(MYSQLI_ASSOC);
            $sentencia->close();
            return array($data, $filasAfectadas);
        } catch (Exception $e) {
            throw new Exception($e, $e->getCode());
            // echo "Error al ejecutar la consulta: " . $sentencia->error;
            // return false;
        }
    }

    public function executeUpdateQuery($query, $params = [])
    {
        $filasAfectadas = 0;
        $data = [];

        try {
            $sentencia = $this->conexion->prepare($query);

            if (!$sentencia) {
                throw new Exception($this->conexion->error, 101);
            }
            // En caso de tener parametros, se preparan los tipos de parametros
            if (!empty($params)) {
                $tipoDatos = $this->getTypeData($params);
                $sentencia->bind_param($tipoDatos, ...$params);
            }
            // Ejecuta la sentencia SQL
            if (!$sentencia->execute()) {
                throw new Exception($this->conexion->error, 102);
            }

            $resultado = $sentencia->get_result();
            $filasAfectadas = $sentencia->affected_rows;
            $sentencia->close();

            return array($resultado, $filasAfectadas);
        } catch (Exception $e) {
            throw new Exception($e, $e->getCode());
            // echo "Error al ejecutar la consulta: " . $sentencia->error;
            // return false;
        }
    }

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

    public function closeDatabase()
    {
        $this->conexion->close();
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
            throw new Exception($e, $e->getCode());
        } finally {
            // Cerrar la conexión a la base de datos
            $this->closeDatabase();
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
            throw new Exception($e, $e->getCode());
        } finally {
            // Cerrar la conexión a la base de datos
            $this->closeDatabase();
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
            throw new Exception($e, $e->getCode());
        } finally {
            // Cerrar la conexión a la base de datos
            $this->closeDatabase();
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
            throw new Exception($e, $e->getCode());
        } finally {
            // Cerrar la conexión a la base de datos
            $this->closeDatabase();
        }
    }
}
