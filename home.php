<?php
require_once './php/classes/database.php';
require_once './php/classes/usuario.php';
require_once './php/classes/cuenta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = (isset($_POST['email']) && is_string($_POST['email'])) ? trim($_POST['email']) : '';
  $password = (isset($_POST['password']) && is_string($_POST['password'])) ? trim($_POST['password']) : '';

  try {
    if (!is_string($email) || !is_string($password)) {
      throw new Exception(" Error en login.php", 201);
    }
    $database = new Database();
    $resultado = $database->getUsuarioByEmail($email);
    if (!$resultado) {
      throw new Exception("Usuario no existe", 202);
    } else {
      $user2 = $resultado;
      $user = $user2[0];
      $usuario = new Usuario(
        $user["user_id"],
        $user["user_nombre"],
        $user["user_apellido"],
        $user["user_email"],
        $user["user_password"],
        $user["user_contacto"],
        $user["user_sexo"],
        $user["user_intentos"],
        $user["user_habilitado"],
      );
    }
    $validacion = $usuario->validarUsuario($email, $password);
    $cuentas = $usuario->obtenerCuentas();
  } catch (Exception $e) {
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    $error = $e->getMessage();
    echo $error;
    $pos = strpos($error, "C:", true);
    $shortError = substr($error, 0, $pos - 4);
    echo '<script>alert("Codigo Error ' . $e->getCode() . ': ' . $shortError  .  '");</script>';
  }
}
?>

<!DOCTYPE html>
<html lang="en" style="background-color: white; height: 100%;">

<head>
  <meta charset=" UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Meta Tags -->
  <meta name="description" content=" Esta es la Home de la plataforma IBWallet, un desarrollo de comercio electrónico que permite que los pagos
           y transferencias de dinero se hagan a través de Internet." />
  <meta name="keywords" content="desarrolo web, dinero, transferencia, deposito, IBWallet, tarjeta bancaria, tarjeta debito, tarjeta credito,transferencia online, finanzas, operaciones financieras, operaciones, credito, debito,login, inicio sesion, sesion" />

  <!-- Opengraph -->
  <meta property="og:title" content="Home | IBWallet | Tu Billetera Digital" />
  <meta property="og:description" content="IBWallet es desarrollo de comercio electrónico que permite que los pagos
        y transferencias de dinero se hagan a través de Internet" />
  <meta property="og:image" content="https://ibwallet.000webhostapp.com/images/login.svg" />

  <!-- Titulo -->
  <title>Home | IBWallet | Tu Billetera Digital </title>

  <!-- Boostrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <!-- CSS -->
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>

  <!-- JScript -->
  <!-- <script src="./js/classes/usuario.js"></script>
  <script src="./js/classes/movimiento.js"></script>
  <script src="./js/driverLocalStore.js" defer></script>
  <script src="./js/main.js" defer></script> -->

</head>

<body id="">

  <!-- header  -->
  <header class=" fixed-top">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container-fluid nav-container">
        <a class="navbar-brand" href="#">IBWallet</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Menu Principal">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="./login.php">Cerrar Sesion</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- home -->
  <section id="home" class="container">
    <br>
    <br>
    <br>
    <br>
    <?php
    $sexo = $usuario->getSexo();
    $bienvenida = "";
    switch ($sexo) {
      case 'M':
        $bienvenida = 'Bienvenido: ' . $usuario->getNombre() . ', ' . $usuario->getApellido();
        break;
      case 'F':
        $bienvenida = 'Bienvenida: ' . $usuario->getNombre() . ', ' . $usuario->getApellido();
        break;
      default:
        $bienvenide = 'Bienvenide: ' . $usuario->getNombre() . ', ' . $usuario->getApellido();
        break;
    }
    echo '<p style="color: #87698d; font-size: 1em; text-align: right;" id="msjBienvenida">' . $bienvenida . '</p>';
    ?>
    <br>
    <div id="cuentas" class="row align-items-start ">
      <div class="col-12">
        <div>
          <h3>RESPUESTAS BD</h3>
          <?php
          echo '<br><p style="font-weight:700">DATOS FORMULARIO:</p>';
          Utils::screenMsj("EMAIL: " . $email);
          Utils::screenMsj("PASSWORD: " . $password);
          $clave_cifrada = hash_hmac('sha256', $password, "IBwallet");
          Utils::screenMsj("PASSWORD ENCRIPTADA: " . $clave_cifrada);
          echo '<br><p style="font-weight:700">DATOS USUARIO DESDE BD:</p>';
          Utils::mostrarUsuarios($resultado);
          echo '<br><p style="font-weight:700">RESULTADO VALIDACION USER:</p>';
          if (isset($validacion) && $validacion) {
            Utils::screenMsj('<p style="color:green; font-weight:700">Credenciales válido. Reinicia Intentos -> Intentos restantes: ' . $usuario->getNroIntentos() . '</p>');
          } else {
            Utils::screenMsj('<p style="color:red; font-weight:700">Credenciales inválido. Intentos restantes: ' . $usuario->getNroIntentos() . '</p>');
            // echo '<script>alert("Credenciales Invalidas");</script>';
          }
          ?>
          <hr>
          <br>
          <h3>Cuentas</h3>
          <hr>
          <br>
          <?php

          if (isset($validacion) && ($validacion || count($cuentas) === 0 || count($cuentasGet) === 0)) {
            echo '<table class="table table-hover text-center">';
            echo '<thead>';
            echo '<tr>';
            echo '<th scope="col">#</th>';
            echo '<th scope="col">Nro. Cuenta</th>';
            echo '<th scope="col">Tipo Cuenta</th>';
            echo '<th scope="col">C.B.U.</th>';
            echo '<th scope="col">Alias</th>';
            echo '<th scope="col">Moneda</th> ';
            echo '<th scope="col">Saldo</th> ';
            echo '</tr> ';
            echo '</thead> ';
            echo '<tbody id="detalleResultadoTabla">';

            foreach ($cuentas as $key => $cuenta) {
              echo '<tr>';
              echo '<th scope="col">' . $key . '</th>';
              echo '<td scope="col">' . $cuenta["cue_nro_cuenta"] . '</th>';
              echo '<td scope="col">' . $cuenta["cue_tipo_cuenta"] . '</th>';
              echo '<td scope="col">' . $cuenta["cue_cbu"] . '</th>';
              echo '<td scope="col">' . $cuenta["cue_alias"] . '</th>';
              echo '<td scope="col">' . $cuenta["cue_tipo_moneda"] . '</th>';
              if ($cuenta["cue_tipo_moneda"] === "PESO") {
                echo '<td scope="col"> $ ' . number_format($cuenta["cue_saldo"], 2) . '</th>';
              } else {
                echo '<td scope="col"> U$S ' . number_format($cuenta["cue_saldo"], 2) . '</th>';
              }
              echo '</tr>';
            }
          } else {
            echo '<p style="color:blue; font-weight:700">No posee cuentas asociadas</p>';
          }
          ?>
          </tbody>
          </table>
        </div>
      </div>
    </div>
    <br>
    <br>
    <h3> Operaciones </h3>
    <hr>
    <?php
    if (isset($validacion) && $validacion && count($cuentas) !== 0) {
      echo '<div class="py-4 mb-5 d-flex" style = "padding: 0px auto;">';
      echo '<form action="transferencias.php" method="get">';
      echo '<input type="hidden" name="user_id" value="' . $usuario->getId() . '">';
      echo '<button id="movimientos" type="submit" class="btn btn-primary mx-3" disabled >Transferir</button>';
      echo '</form>';

      echo '<form action="movimientos.php" method="get" >';
      echo '<input type="hidden" name="user_id" value="' . $usuario->getId() . '">';
      echo '<button id="movimientos" type="submit" class="btn btn-success mx-3">Ver movimientos</button>';
      echo '</form>';
      echo ' </div>';
    } else {
      echo '<div class="align-items-center py-4 mb-5">';
      echo '<p style="color:red; font-weight:700">No puede realizar operaciones</p>';
      echo ' </div>';
    }
    ?>

  </section>
</body>

</html>