<?php
require_once "./app/classes/database.php";
require_once "./app/classes/usuario.php";
require_once "./app/classes/cuenta.php";
require_once "./app/classes/movimiento.php";
require_once "./app/classes/utils.php";

// Comprobar si la sesión está iniciada
try {
  if (!session_start()) {
    throw new Exception("Error al cargar la sesión del usuario logueado");
  }

  // Obtener datos de la session PHP 
  $user_id = $_SESSION['user']['id'] ?? '';
  if (empty($user_id)) {
    throw new Exception("No se pudieron obtener los datos de la sesión");
  }

  // Obtener el usuario desde BD
  $databaseUser = new Database();
  $resultado = $databaseUser->getUsuarioById($user_id);

  if (!$resultado) {
    throw new Exception("No se ha podido recuperar los datos del usuario");
  }

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
  // Obtener las cuentas del usuario
  $cuentasUsuario = $usuario->obtenerCuentas();
} catch (Exception $e) {
  header("Location: error.html");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $nroCuentaOrigen = (isset($_POST['cuentaOrigen']) && is_string($_POST['cuentaOrigen'])) ? trim($_POST['cuentaOrigen']) : 'seleccionar';
    $nroCuentaDestino = (isset($_POST['cuentaDestino']) && is_string($_POST['cuentaDestino'])) ? trim($_POST['cuentaDestino']) : 'seleccionar';
    $importe = (isset($_POST['importe']) && is_string($_POST['importe'])) ? $_POST['importe'] : '';

    if ($nroCuentaOrigen === "selecionar" || $nroCuentaDestino === "seleccionar") {
      throw new Exception("Alguna de las cuentas no fue seleccionada");
    }

    if ($nroCuentaOrigen === $nroCuentaDestino) {
      throw new Exception("Las cuentas tienen que ser distintas");
    }

    if (is_numeric($importe)) {
      $importe = floatval($importe);
      $importe = round($importe, 2);
    } else {
      throw new Exception("El importe no es valido");
    }

    $databaseCuentaOrigen = new Database();
    $datosCuentaOrigen = $databaseCuentaOrigen->getCuentabyNroCuenta($nroCuentaOrigen);

    $databaseCuentaDestino = new Database();
    $datosCuentaDestino = $databaseCuentaDestino->getCuentabyNroCuenta($nroCuentaDestino);

    $cuentaOrigen = new Cuenta(
      $datosCuentaOrigen[0]["cue_id"],
      $datosCuentaOrigen[0]["cue_user_id"],
      $datosCuentaOrigen[0]["cue_nro_cuenta"],
      $datosCuentaOrigen[0]["cue_tipo_cuenta"],
      $datosCuentaOrigen[0]["cue_tipo_moneda"],
      $datosCuentaOrigen[0]["cue_cbu"],
      $datosCuentaOrigen[0]["cue_alias"],
      $datosCuentaOrigen[0]["cue_saldo"],
    );

    $cuentaDestino = new Cuenta(
      $datosCuentaDestino[0]["cue_id"],
      $datosCuentaDestino[0]["cue_user_id"],
      $datosCuentaDestino[0]["cue_nro_cuenta"],
      $datosCuentaDestino[0]["cue_tipo_cuenta"],
      $datosCuentaDestino[0]["cue_tipo_moneda"],
      $datosCuentaDestino[0]["cue_cbu"],
      $datosCuentaDestino[0]["cue_alias"],
      $datosCuentaDestino[0]["cue_saldo"],
    );

    if ($cuentaOrigen->getTipoMoneda() !== $cuentaDestino->getTipoMoneda()) {
      throw new Exception("Las cuentas deben tener la misma moneda");
    }

    $transaccion = $cuentaOrigen->registrarTransacccion($cuentaDestino, $importe);
    if ($transaccion) {
      $msjExito = "La transaccción se ha realizado con éxito";
    }
  } catch (Exception $e) {
    $msjError = $e->getMessage();
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Meta Tags -->
  <meta name="description" content=" Este es el login de la plataforma IBWallet, un desarrollo de comercio electrónico que permite que los pagos
       y transferencias de dinero se hagan a través de Internet." />
  <meta name="keywords" content="desarrolo web, dinero, transferencia, deposito, IBWallet, tarjeta bancaria, tarjeta debito, tarjeta credito,transferencia online, finanzas, operaciones financieras, operaciones, credito, debito,login, inicio sesion, sesion" />

  <!-- Opengraph -->
  <meta property="og:title" content="Transferencias | IBWallet | Tu Billetera Digital" />
  <meta property="og:description" content="IBWallet es desarrollo de comercio electrónico que permite que los pagos
    y transferencias de dinero se hagan a través de Internet" />
  <meta property="og:image" content="https://ibwallet.000webhostapp.com/images/login.svg" />

  <!-- Titulo -->
  <title>Transferencias | IBWallet | Tu Billetera Digital </title>

  <!-- Boostrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <!-- CSS -->
  <link rel="stylesheet" href="./css/style.css">

</head>

<body id="" style="background-image: linear-gradient(180deg, #fff9ff 20%, #f2e3ff 100%); height: 1200px;">
  <!-- header -->
  <header class="fixed-top">
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

  <!-- movimientos -->
  <section id="section-transf" class="container">
    <br>
    <br>
    <br>
    <br>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home.php">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Transferencias</li>
      </ol>
    </nav>
    <h3>Transferencias</h3>
    <hr>
    <br>
    <?php
    if ($cuentasUsuario !== false && count($cuentasUsuario) !== 0) {
      echo '<div id="transferencias" class="col-12 pt-2">';
      echo '<form id="formTransferencias" action="transferencias.php" method="post">';
      echo '<label for="origen" style="font-weight: 600;">Cuenta origen:</label><br>';
      echo '<select class="form-control" style="width: 500px;" name="cuentaOrigen" id="cuentaOrigen">';
      echo '<option value="seleccionar" selected>Seleccionar...</option>';
      foreach ($cuentasUsuario as $cuenta) {
        $valorCuenta = $cuenta["cue_tipo_cuenta"] . ' - ' . (($cuenta["cue_tipo_moneda"] === "PESO") ? '$' : 'U$S') . ' - ' .  $cuenta["cue_nro_cuenta"] . ' [' . (($cuenta["cue_tipo_moneda"] === "PESO") ? '$ ' : 'U$S ') . $cuenta["cue_saldo"] . ']';
        echo '<option value="' . $cuenta["cue_nro_cuenta"] . '">' . $valorCuenta . '</option>';
      }
      echo '</select><br>';
      echo '<label for="origen" style="font-weight: 600;">Cuenta Destino:</label><br>';
      echo '<select class="form-control" style="width: 500px;" name="cuentaDestino" id="cuentaDestino">';
      echo '<option value="seleccionar" selected>Seleccionar...</option>';
      foreach ($cuentasUsuario as $cuenta) {
        $valorCuenta = $cuenta["cue_tipo_cuenta"] . ' - ' . (($cuenta["cue_tipo_moneda"] === "PESO") ? '$' : 'U$S') . ' - ' . $cuenta["cue_nro_cuenta"];
        echo '<option value="' . $cuenta["cue_nro_cuenta"] . '">' . $valorCuenta . '</option>';
      }
      echo '</select><br>';
      echo '<label for="importe" style="font-weight: 600;">Importe:</label>';
      echo '<input type="text" name="importe" id="importe" class="form-control" style="width: 500px;">';
      echo '<div class="col-12 mensaje-container" id="msjError" style="margin: 1vh 0px; max-height: 50x; height: 50px;">';
      if (isset($msjError) && !empty($msjError)) {
        echo '<div id="alerta" class="alert alert-danger role="alert" style="max-height: 40px; font-weight: 600;display: flex; align-items: center;justify-content: center;">' . $msjError . '</div>';
        echo '<script>
              setTimeout(function() {
                  document.getElementById("alerta").style.display = "none";
              }, 4000);
          </script>';
      }
      if (isset($msjExito) && !empty($msjExito)) {
        echo '<div id="alerta" class="alert alert-success role="alert" style="max-height: 40px; font-weight: 600;display: flex; align-items: center;justify-content: center;">' . $msjExito . '</div>';
        echo '<script>
              setTimeout(function() {
                  document.getElementById("alerta").style.display = "none";
                  window.location.href = window.location.href;
              }, 1500);
          </script>';
      }
      echo '</div>';
      echo '<button id="btn-transferir" type="submit" class="btn btn-primary" style="width:200px;font-weight:600;height:50px;">Transferir</button>';
      echo '</form>';
    }
    echo '<br>';
    echo '<br>';
    echo '<form action="home.php">';
    echo '<button type="submit" class="btn btn-danger" style="width:200px;font-weight:600;height:50px;">Volver</button>';
    echo '</form>';
    echo '<br>';
    echo '</div>'

    ?>
  </section>
  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- JScript -->
  <script src="./js/transferencias.js"></script>
</body>

</html>