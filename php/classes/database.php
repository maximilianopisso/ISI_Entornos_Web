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
        $this->conexion = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conexion->connect_error) {
            throw new Exception($this->conexion->connect_error, 100);
        } else {
            $this->conexion->set_charset('utf8mb4');
        }
    }

    public function executeQuery($query, $params = [])
    {
        $filasAfectadas = 0;
        $data = [];

        try {
            $sentencia = $this->conexion->prepare($query);

            if (!$sentencia) {
                throw new Exception($this->conexion->error, 101);
            }

            if (!empty($params)) {
                $tipoDatos = $this->getTypeData($params);
                $sentencia->bind_param($tipoDatos, ...$params);
            }

            if (!$sentencia->execute()) {
                throw new Exception($this->conexion->error, 102);
            }

            $resultado = $sentencia->get_result();
            $data[] = $resultado->fetch_all(MYSQLI_ASSOC);
            $filasAfectadas = $sentencia->affected_rows;
            $sentencia->close();

            return array($data, $filasAfectadas);
        } catch (Exception $e) {
            Utils::msjCodigoError($e->getCode(), $e);
            // echo "Error al ejecutar la consulta: " . $sentencia->error;
            return false;
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
        // Consulta SELECT con parámetros
        $query = "SELECT * FROM usuarios WHERE user_email = ?";
        //Parametros
        try {
            $resultado = $this->executeQuery($query, [$email]);
            if ($resultado[1] !== 0) {
                return $resultado[0];
            } else {
                return false;
            };
        } catch (Exception $e) {
            Utils::msjCodigoError($e->getCode(), $e);
        } finally {
            // Cerrar la conexión a la base de datos
            $this->closeDatabase();
        }
    }

    public function existeUsuario($email)
    {
        // Consulta SELECT con parámetros
        $query = "SELECT * FROM usuarios WHERE user_email = ?";
        //Parametros
        try {
            $resultado = $this->executeQuery($query, [$email]);
            if ($resultado[1] !== 0) {
                return true;
            } else {
                return false;
            };
        } catch (Exception $e) {
            echo 'Código ' . $e->getCode() . ' - ' . $e->getMessage();
        } finally {
            // Cerrar la conexión a la base de datos
            $this->closeDatabase();
        }
    }
}
