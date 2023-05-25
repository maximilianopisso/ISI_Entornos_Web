<?php
require 'utils.php';

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
    public function __construct()
    {
        $this->nombre = 0;
        $this->nombre = "";
        $this->apellido = "";
        $this->email = "";
        $this->password = "";
        $this->contacto = "";
        $this->sexo = "";
        $this->nroIntentos = 3;
        $this->habilitado = 1;
    }
    // public function __construct($id, $nombre, $apellido, $email, $password, $contacto, $sexo)
    // {
    //     $this->nombre = $nombre;
    //     $this->apellido = $apellido;
    //     $this->email = $email;
    //     $this->password = $password;
    //     $this->contacto = $contacto;
    //     $this->sexo = $sexo;
    //     $this->nroIntentos = 3;
    //     $this->habilitado = true;
    // }

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

    public function restarNroIntentos($email)
    {
        if ($this->nroIntentos === 0) {
            return false;
        } else {
            $this->nroIntentos--;
            return true;
        }
    }

    public function inhabilitarUsuario()
    {
        $this->habilitado = 0;
    }

    public function habilitarUsuario()
    {
        $this->habilitado = 1;
        $this->resetNroIntentos();
    }

    public function validarUsuario($email, $clave)
    {
        //
        try {

            $nroIntentos = $this->getNroIntentos();
            if ($nroIntentos == 0) {
                if ($this->habilitado !== 1) {
                    $this->inhabilitarUsuario();
                }
                throw new Exception("Usuario Bloqueado", 200);
            }

            $habilitado = $this->getHabilitado();
            if ($habilitado !== 1) {
                throw new Exception("Usuario Inhabilitado", 201);
            }

            // Recuperar la clave de la base de datos 
            $this->email = 'mpisso@gmail.com';
            $this->password = '7e713a2eef2ca385b216ad6722b58558de3cad1f6e016f2cd1bdffac62d22d0d';

            // Cifrar clave que entra por formulario
            $claveCifrada = $this->cifrarClave($clave);
            Utils::screenMsj(var_dump($this->password));
            Utils::screenMsj(var_dump($clave));
            Utils::screenMsj(var_dump($claveCifrada));

            // Verificar la clave ingresada con la versión cifrada almacenada en la base de datos
            if ($claveCifrada == $this->password && $this->email == $email) {
                Utils::screenMsj("Usuario válido");
                return true;
            } else {
                if ($this->email == $email) {
                    $this->restarNroIntentos($email);
                }
                Utils::screenMsj("Credenciales invalidas");
                return false;
            }
        } catch (Exception $e) {
            Utils::screenMsj($e);
        }
    }


    public function obtenerCuentas()
    {
    }

    public function obtenerMovimientos()
    {
    }

    public function agregarMovimiento($tipo, $monto)
    {
        $movimiento = [
            "tipo" => $tipo,
            "monto" => $monto,
            "fecha" => date("Y-m-d H:i:s")
        ];
        // $this->movimientos[] = $movimiento;
    }

    public function visualizarMovimientos()
    {
        // // foreach ($this->movimientos as $movimiento) {
        //     echo "Tipo: " . $movimiento['tipo'] . ", Monto: " . $movimiento['monto'] . ", Fecha: " . $movimiento['fecha'] . "<br>";
        // }
    }
    public function cifrarClave($clave)
    {
        // $salt_fijo = "IBWallet"; // Sal fija que se utilizará en cada cifrado

        // $options = [
        //     'salt' => $salt_fijo,
        // ];

        // $clave_cifrada = password_hash($clave, PASSWORD_DEFAULT, $options);

        // return $clave_cifrada;


        $secret_key = "IBwallet"; // Secret key for HMAC

        $clave_cifrada = hash_hmac('sha256', $clave, $secret_key);
        return $clave_cifrada;
    }
}

$usuario = new Usuario();
$usuario->validarUsuario("mpisso@gmail.com", "clave1111");
var_dump($usuario);
