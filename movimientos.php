<?php
require_once "./app/classes/database.php";
require_once "./app/classes/usuario.php";
require_once "./app/classes/cuenta.php";
require_once "./app/classes/movimiento.php";
require_once "./app/classes/utils.php";

define('MAX_CANT_MOVIMIENTOS', 10);
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

// Procesar formulario de selección de cuenta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nroCuenta = $_POST['selectCuenta'] ?? 'seleccionar';

  // Obtener movimientos de la cuenta seleccionada
  if ($nroCuenta !== "seleccionar") {
    try {
      $database = new Database();
      $datosCuenta = $database->getCuentabyNroCuenta($nroCuenta);
      $cuentaSeleccionada = new Cuenta(
        $datosCuenta[0]["cue_id"],
        $datosCuenta[0]["cue_user_id"],
        $datosCuenta[0]["cue_nro_cuenta"],
        $datosCuenta[0]["cue_tipo_cuenta"],
        $datosCuenta[0]["cue_tipo_moneda"],
        $datosCuenta[0]["cue_cbu"],
        $datosCuenta[0]["cue_alias"],
        $datosCuenta[0]["cue_saldo"]
      );
      $movimientosCuenta = $cuentaSeleccionada->obtenerMovimientos();
    } catch (Exception $e) {
      $error = $e->getMessage();
      Utils::alert('Error: ' . $error);
    }
  } else {
    $msjError = "No se ha seleccionado una cuenta";
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
  <meta property="og:title" content="Movimientos | IBWallet | Tu Billetera Digital" />
  <meta property="og:description" content="IBWallet es desarrollo de comercio electrónico que permite que los pagos
    y transferencias de dinero se hagan a través de Internet" />
  <meta property="og:image" content="https://ibwallet.000webhostapp.com/images/login.svg" />

  <!-- Titulo -->
  <title>Movimientos | IBWallet | Tu Billetera Digital </title>

  <!-- Boostrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <!-- CSS -->
  <link rel="stylesheet" href="./css/appStyle.css">

</head>

<body>

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
  <section id="movimientos" class="container">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home.php">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Movimientos</li>
      </ol>
    </nav>
    <?php
    echo '<div id="movimientos" class="col-12 pt-4">';
    if (isset($cuentasUsuario) && count($cuentasUsuario) !== 0) {
      echo '<form action="movimientos.php" method="post">';
      echo '<label for="seleccionarCuenta" style="font-weight: 600;">Seleccioná tu cuenta:</label>';
      echo '<br>';
      echo '<select class="form-control" style="width: 500px;" name="selectCuenta">';
      echo '<option value="seleccionar" selected>Seleccionar...</option>';
      foreach ($cuentasUsuario as $cuenta) {
        $valorCuenta = $cuenta["cue_tipo_cuenta"] . ' - ' . (($cuenta["cue_tipo_moneda"] === "PESO") ? '$' : 'U$S') . ' - ' . $cuenta["cue_nro_cuenta"];
        echo '<option value="' . $cuenta["cue_nro_cuenta"] . '">' . $valorCuenta . '</option>';
      }
      echo '</select>';
      echo '<div class="col-12 mensaje-container my-2" id="msjError" style="height: 35px; max-height: 35px;">';
      if (isset($msjError)) {
        echo
        '<div id="alerta" class="alert alert-danger" role="alert" style="height:25px; max-height: 25px; font-weight: 600;display: flex; align-items: center;justify-content: center;">' . $msjError . '</div>';
        echo '<script>
              setTimeout(function() {
                  document.getElementById("alerta").style.display = "none";
              }, 2000);
          </script>';
      }
      echo '</div>';
      echo '<button id="verMovimientos" type="submit" class="btn btn-success" style= "width:200px;height:50px;font-weight:600;">Ver Movimientos</button>';
      echo '</form>';
    } else {
      echo '<p style="color:blue; font-weight:700">No posee cuentas</p>';
    }
    echo '</div>';
    echo '<br>';
    echo '<h3>Últimos Movimientos</h3>';
    echo '<hr>';

    if (isset($cuentaSeleccionada)) {
      // Si existen movimientos en la cuenta seleccionada, los muestro.
      if ($movimientosCuenta !== false && count($movimientosCuenta) !== 0) {
        $maxRegistros = min(count($movimientosCuenta), MAX_CANT_MOVIMIENTOS);
        echo '<table class="table table-hover text-center estilo-tabla">';
        echo '<thead id="headTablaMovimientos">';
        echo '<tr>';
        echo '<th scope="col">#</th>';
        echo '<th scope="col">Fecha</th>';
        echo '<th scope="col">Nro. Transacción</th>';
        echo '<th scope="col">Descripción</th>';
        echo '<th scope="col">Importe</th>';
        echo '<th scope="col">Saldo</th>';
        echo '</tr> ';
        echo '</thead> ';
        echo '<tbody id="bodyTablaMovimientos">';
        // Se coloca el signo correcto de la moneda, en funcion del tipo de moneda de la cuenta seleccionada.
        $moneda = ($cuentaSeleccionada->getTipoMoneda() === "PESO" ? '$ ' : 'U$S ');

        for ($i = 0; $i < $maxRegistros; $i++) {
          $movimiento = $movimientosCuenta[$i];
          echo '<tr>';
          echo '<td scope="col">' . $i + 1 . '</td>';
          echo '<td scope="col">' . $movimiento["mov_fecha"] . '</th>';
          echo '<td scope="col">' . $movimiento["mov_nro_transaccion"] . '</th>';
          echo '<td scope="col">' . $movimiento["mov_descripcion"] . '</th>';
          //Si es una transferencia de dinero, el importe resta. El valor se muestra con un - por delante y en color rojo, caso contrario sin signo y en color verde.
          $signo = (strpos($movimiento["mov_descripcion"], "Transferencia") !== false) ? '-' : '';
          if ($signo === '-') {
            echo '<td scope="col" style="color:red;">'  . $moneda . $signo . number_format($movimiento["mov_importe"], 2) . '</th>';
          } else {
            echo '<td scope="col" style="color:green;">'  . $moneda . $signo . number_format($movimiento["mov_importe"], 2) . '</th>';
          }
          echo '<td scope="col">' . $moneda . number_format($movimiento["mov_saldo"], 2) . '</th>';
          echo '</tr>';
        }
        echo ' </tbody>';
        echo ' </table>';
      } else {
        //Cuando no existen movimientos en la cuenta seleccionada, muestro el msj
        echo '<p style="color:blue; font-weight:700">La cuenta seleccionada no registra ningún movimiento.</p>';
      }
    } else {
      //Hasta que no se seleccione una cuenta, muestro el msj.
      echo '<p style="color:red; font-weight:700">Seleccione una cuenta para ver sus últimos movimientos.</p>';
    }
    echo '</div>';
    echo '<br>';
    echo '<form>';
    echo '<button type="submit" formaction="home.php" class="btn btn-danger" style= "width:200px;height:50px;font-weight:600;">Volver</button>';
    echo '</form>';
    echo ' <br> ';
    ?>
  </section>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>

</html>