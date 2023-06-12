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
    public function getNombre()
    {
        return $this->nombre;
    }

    public function getId()
    {
        return $this->id;
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

    public function getNroIntentos()
    {
        return $this->nroIntentos;
    }

    public function getHabilitado()
    {
        return $this->habilitado;
    }

    // METODOS PERSONALIZADOS
    public function resetNroIntentos()
    {
        try {
            $this->nroIntentos = 3;
            $database = new Database();
            $query = "UPDATE `usuarios` SET user_intentos = 3 where user_id = ?";
            $resultado = $database->executeUpdateQuery($query, [$this->id]);
            // var_dump($resultado);
            // if ($resultado[1] !== 0) {
            //     return true;
            // } else {
            //     throw new Exception("Error no se pudo reiniciar intentos al usuario", 105);
            // };
            //REVISAR SI ESTA BIEN ESTO O COMO ESE PUEDE HACER, PORQUE CUANDO EL VALOR ES 3 DEVUELVA COMO QUE NO HIZO CAMBIOS Y FALLA, CUANDO NO ES UNA FALLA

        } catch (Exception $e) {
            throw new Exception($e, $e->getCode());
        } finally {
            // Cerrar la conexión a la base de datos
            $database->closeDatabase();
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
                } else {
                    throw new Exception("Error no se pudo restar el numero de intentos del usuario", 105);
                };
            } catch (Exception $e) {
                throw new Exception($e, $e->getCode());
            } finally {
                $database->closeDatabase();
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
            } else {
                throw new Exception("Error no se pudo inhabilitar al usuario", 105);
            };
        } catch (Exception $e) {
            throw new Exception($e, $e->getCode());
        } finally {
            // Cerrar la conexión a la base de datos
            $database->closeDatabase();
        }
    }

    public function habilitarUsuario()
    {
        try {
            $this->habilitado = 1;
            $database = new Database();
            $query = "UPDATE `usuarios` SET user_habilitado = 3 where user_id = ?";
            $resultado = $database->executeUpdateQuery($query, [$this->habilitado]);
            if ($resultado[1] !== 0) {
                $this->resetNroIntentos();
                return true;
            } else {
                throw new Exception("Error no se pudo habilitar al usuario", 105);
            };
        } catch (Exception $e) {
            throw new Exception($e, $e->getCode());
        } finally {
            // Cerrar la conexión a la base de datos
            $database->closeDatabase();
        }
    }

    public function validarUsuario(string $email, string $clave)
    {
        //
        try {
            //Validacion Inhabilitado
            if ($this->habilitado !== 1) {
                return array(false, 'El usuario se encuentra BLOQUEADO');
            }

            // Encripta clave ingresada por formulario.
            $claveCifrada = $this->cifrarClave($clave);

            // Verificar la clave ingresada con la versión cifrada almacenada en la base de datos
            if ($claveCifrada === $this->password && $this->email === $email) {
                $this->resetNroIntentos();
                return array(true, "Usuario Validado");
            } else {
                if ($this->email === $email) {
                    $this->restarNroIntentos();
                    if ($this->nroIntentos === 0) {
                        $this->inhabilitarUsuario();
                        return array(false, 'La contraseña es incorrecta. El usuario fue BLOQUEADO');
                    }
                }
                return array(false, 'La contraseña es incorrecta. Nro Intentos: ' . $this->nroIntentos);
            }
        } catch (Exception $e) {
            throw new Exception($e, $e->getCode());
        }
    }
    public function cifrarClave($clave)
    {
        $secret_key = "IBwallet"; // Secret key for HMAC
        $clave_cifrada = hash_hmac('sha256', $clave, $secret_key);
        return $clave_cifrada;
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
            throw new Exception($e, $e->getCode());
        } finally {
            // Cerrar la conexión a la base de datos
            $database->closeDatabase();
        }
    }

    public function obtenerCuenta($nroCuenta)
    {
        try {
            $query = "SELECT * FROM cuentas WHERE cue_user_id = ? AND cue_nro_cuenta = ?";
            $database = new Database();
            $resultado = $database->executeSelectQuery($query, [$this->id, $nroCuenta]);
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
