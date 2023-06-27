<?php
require 'utils.php';
require_once 'database.php';

class Usuario
{
    private $id;
    private $nombre;
    private $apellido;
    private $email;
    private $password;
    private $contacto;
    private $sexo;
    private $nroIntentos;
    private $habilitado;

    public function __construct($id, $nombre, $apellido, $email, $password, $contacto, $sexo, $intentos, $habilitado)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->password = $password;
        $this->contacto = $contacto;
        $this->sexo = $sexo;
        $this->nroIntentos = $intentos;
        $this->habilitado = $habilitado;
    }
    // GETTERS
    public function getApellido()
    {
        return $this->apellido;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    // METODOS PERSONALIZADOS
    public function resetNroIntentos()
    {
        try {
            $this->nroIntentos = 3;
            $database = new Database();
            $query = "UPDATE `usuarios` SET user_intentos = ? where user_id = ?";
            $database->executeUpdateQuery($query, [$this->nroIntentos, $this->id]);
        } catch (Exception $e) {
            throw new Exception("Falla al reiniciar el numero de intentos del usuario", $e->getCode());
        }
    }

    public function restarNroIntentos()
    {
        if ($this->nroIntentos === 0) {
            return false;
        } else {
            try {
                $this->nroIntentos--;
                $database = new Database();
                $query = "UPDATE usuarios SET user_intentos = ? where user_id = ?";
                $resultado = $database->executeUpdateQuery($query, [$this->nroIntentos, $this->id]);
                if ($resultado[1] !== 0) {
                    return true;
                }
            } catch (Exception $e) {
                throw new Exception("Falla al restar el numero de intentos del usuario", $e->getCode());
            }
        }
    }

    public function inhabilitarUsuario()
    {
        try {
            $this->habilitado = 0;
            $database = new Database();
            $query = "UPDATE usuarios SET user_habilitado = ? where user_id = ?";
            $resultado = $database->executeUpdateQuery($query, [$this->habilitado, $this->id]);
            if ($resultado[1] !== 0) {
                return true;
            }
        } catch (Exception $e) {
            throw new Exception("Falla al inhabilitar al usuario", $e->getCode());
        }
    }

    public function habilitarUsuario()
    {
        try {
            $this->habilitado = 1;
            $database = new Database();
            $query = "UPDATE usuarios SET user_habilitado = ? where user_id = ?";
            $resultado = $database->executeUpdateQuery($query, [$this->habilitado, $this->id]);
            if ($resultado[1] !== 0) {
                return true;
            }
        } catch (Exception $e) {
            throw new Exception("Falla al habilitar al usuario", $e->getCode());
        }
    }

    /**
     * Método que devuelve la clave encriptada de la que es ingresada por el usuario.
     */
    public function cifrarClave($password)
    {
        $secret_key = "IBwallet"; // Secret key for HMAC
        $passwordCifrada = hash_hmac('sha256', $password, $secret_key);
        return $passwordCifrada;
    }

    public function validarUsuario(string $email, string $password)
    {
        try {
            //Validacion Inhabilitado
            if ($this->habilitado !== 1) {
                throw new Exception('El usuario se encuentra INHABILITADO');
                return 'El usuario se encuentra INHABILITADO';
            }

            //Validacion Inhabilitado
            if ($this->nroIntentos <= 0) {
                throw new Exception('El usuario ha superado el numero de intentos fallidos');
                return 'El usuario ha superado el numero de intentos fallidos';
            }

            // Encripta clave ingresada por formulario.
            $passwordCifrada = $this->cifrarClave($password);

            // Verificar la clave ingresada con la versión cifrada almacenada en la base de datos
            if ($passwordCifrada === $this->password && $this->email === $email) {
                if ($this->nroIntentos !== 3) {
                    $this->resetNroIntentos();
                }
                return true;
            } else {
                if ($this->email === $email) {
                    $this->restarNroIntentos();
                    if ($this->nroIntentos === 0) {
                        $this->inhabilitarUsuario();
                        throw new Exception('El usuario fue INHABILITADO');
                        // return 'El usuario fue INHABILITADO';
                    }
                }
                throw new Exception("El email o el password ingresado es incorrecto.", 1);
                // return 'El email o el password ingresado es incorrecto.';
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function obtenerCuentas()
    {
        try {
            $query = "SELECT * FROM cuentas WHERE cue_user_id = ?";
            $database = new Database();
            $resultado = $database->executeSelectQuery($query, [$this->id]);
            if ($resultado[1] !== 0) {
                return $resultado[0];
            } else {
                return false;
            };
        } catch (Exception $e) {
            throw new Exception("Falla al obtener las cuentas pertenecientes al usuario", $e->getCode());
        }
    }
}
