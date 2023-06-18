<?php
require_once './app/classes/database.php';
require_once './app/classes/usuario.php';
require_once './app/classes/cuenta.php';

$resultado = session_start();
if ($resultado === true) {
  $user_id = (isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '');
  $user_nombre = (isset($_SESSION['user']['nombre']) ? $_SESSION['user']['nombre'] : '');
  $user_apellido = (isset($_SESSION['user']['apellido']) ? $_SESSION['user']['apellido'] : '');
  $user_sexo = (isset($_SESSION['user']['sexo']) ? $_SESSION['user']['sexo'] : '');

  try {
    if (empty($user_id) || empty($user_nombre) || empty($user_apellido) || empty($user_sexo)) {
      throw new Exception("No se pudieron obtener los datos de la session");
    }

    $database = new Database();
    $resultado = $database->getUsuarioById($user_id);
    if (!$resultado) {
      throw new Exception("No se ha podido recuperar los datos del usuario");
    } else {
      $usuario = new Usuario(
        $resultado[0]["user_id"],
        $resultado[0]["user_nombre"],
        $resultado[0]["user_apellido"],
        $resultado[0]["user_email"],
        $resultado[0]["user_password"],
        $resultado[0]["user_contacto"],
        $resultado[0]["user_sexo"],
        $resultado[0]["user_intentos"],
        $resultado[0]["user_habilitado"]
      );
    }
    $cuentas = $usuario->obtenerCuentas();
  } catch (Exception $e) {
    $error = $e->getMessage();
    $codeError = $e->getCode();
    Utils::alert('Error: ' . $codeError);
    if ($codeError = 400) {
      header("Location: error.html");
    } else {
      Utils::alert('Error: ' . $error);
    }
  }
} else {
  Utils::alert("Error al cargar la sesion del usuario logueado");
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
  <meta property="og:image" content="https:ibwallet.000webhostapp.com/images/login.svg" />

  <!-- Titulo -->
  <title>Home | IBWallet | Tu Billetera Digital </title>

  <!-- Boostrap -->
  <link href="https:cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <!-- CSS -->
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="https:cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body id="" style="background-image: linear-gradient(180deg, #fff9ff 20%, #f2e3ff 100%); height: 1200px;">
  <!-- header -->
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
              <a class="nav-link" href="./login.php?logout">Cerrar Sesión</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- home  -->
  <section id="home" class="container">
    <br>
    <br>
    <br>
    <br>
    <?php
    switch ($user_sexo) {
      case 'M':
        $bienvenida = 'Bienvenido: ';
        break;
      case 'F':
        $bienvenida = 'Bienvenida: ';
        break;
      default:
        $bienvenide = 'Bienvenide: ';
        break;
    }
    echo '<p style="color: #87698d; font-size: 1.2em; text-align: right;" id="msjBienvenida">' . $bienvenida . $user_nombre . ',' . $user_apellido . '</p>';
    ?>
    <br>
    <div id="cuentas" class="row align-items-start ">
      <div class="col-12">
        <div>
          <h3>Cuentas</h3>
          <hr>
          <br>
          <?php
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
          if ($cuentas) {
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
    if ($cuentas) {
      echo '<div class="py-4 mb-5 d-flex" style = "padding: 0px auto;">';
      echo '<form action="transferencias.php">';
      echo '<button type="submit" id="transferir"  class="btn btn-primary mx-3" style="width:200px;font-weight:600;height:50px;">Transferir</button>';
      echo '</form>';
      echo '<form action="movimientos.php">';
      echo '<button type="submit" id="verMovimientos"  class="btn btn-success mx-3" style="width:200px;font-weight:600;height:50px;">Ver movimientos</button>';
      echo '</form>';
      // echo '<form action="login.php?logout" >';
      // echo '<button type="submit" id="verMovimientos" value="logout" class="btn btn-danger mx-3" style="width:200px;font-weight:600;height:50px;">Volver</button>';
      // echo '</form>';
      echo ' </div>';
    } else {
      echo '<div class="align-items-center py-4 mb-5">';
      echo '<p style="color:red; font-weight:700">No tiene cuentas para poder </p>';
      echo ' </div>';
    }
    ?>
  </section>
  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>

</html>