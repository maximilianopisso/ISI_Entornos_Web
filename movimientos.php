<?php
require_once "./php/classes/database.php";
require_once "./php/classes/usuario.php";
require_once "./php/classes/cuenta.php";
require_once "./php/classes/movimiento.php";
require_once "./php/classes/utils.php";

$resultado = session_start();
if ($resultado === true) {
  $user_id = (isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '(no seteado)');

  // Obtenermos el usuario
  try {
    $databaseUser = new Database();
    $resultado = $databaseUser->getUsuarioById($user_id);
    if (!$resultado) {
      throw new Exception("No se ha podido recuperar los datos del usuario", 202);
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
    $cuentasUsuario = $usuario->obtenerCuentas();
  } catch (Exception $e) {
    $codeError = $e->getCode();
    $error = $e->getMessage();
    $pos = strpos($error, "C:", true);
    $shortError = substr($error, 0, $pos - 4);
    Utils::alert("Codigo Error ' . $codeError . ': ' . $shortError  .  '");
  }
} else {
  Utils::alert("Error al cargar la sesion del usuario logueado");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nroCuenta = (isset($_POST['selectCuenta']) && is_string($_POST['selectCuenta'])) ? trim($_POST['selectCuenta']) : 'seleccionar';

  // Obtenemos movimientos de la cuenta seleccionada
  if ($nroCuenta !== "seleccionar") {
    try {
      $databaseCuenta = new Database();
      $datosCuenta = $databaseCuenta->getCuentabyNroCuenta($nroCuenta);
      $cuentaSeleccionada = new Cuenta(
        $datosCuenta[0]["cue_id"],
        $datosCuenta[0]["cue_user_id"],
        $datosCuenta[0]["cue_nro_cuenta"],
        $datosCuenta[0]["cue_tipo_cuenta"],
        $datosCuenta[0]["cue_tipo_moneda"],
        $datosCuenta[0]["cue_cbu"],
        $datosCuenta[0]["cue_alias"],
        $datosCuenta[0]["cue_saldo"],
      );
      $movimientosCuenta = $cuentaSeleccionada->obtenerMovimientos();
    } catch (Exception $e) {
      $codeError = $e->getCode();
      $error = $e->getMessage();
      $pos = strpos($error, "C:", true);
      $shortError = substr($error, 0, $pos - 4);
      // Utils::alert("Codigo Error ' . $codeError . ': ' . $shortError  .  '");
      $msjError = "'Código error '  .$codeError .': ' .$shortError";
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
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>

</head>

<body id="" style="background-image: linear-gradient(180deg, #fff9ff 20%, #f2e3ff 100%); height: 700px;">

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
              <a class="nav-link" href="./login.php">Cerrar Sesion</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- movimientos -->
  <section id="section-mov" class="container">
    <br>
    <br>
    <br>
    <br>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home.php">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Movimientos</li>
      </ol>
    </nav>
    <?php
    if (isset($cuentasUsuario) && count($cuentasUsuario) !== 0) {
      echo '<div id="movimientos" class="col-12 pt-4">';
      echo '<form action="movimientos.php" method="post">';
      echo '<label for="" style="font-weight: 600;">Seleccioná tu cuenta:</label>';
      echo '<br>';
      echo '<select class="form-control" style="width: 500px;" name="selectCuenta">';
      echo '<option value="seleccionar" selected>Seleccionar...</option>';
      foreach ($cuentasUsuario as $cuenta) {
        $valorCuenta = $cuenta["cue_tipo_cuenta"] . ' - ' . (($cuenta["cue_tipo_moneda"] === "PESO") ? '$' : 'U$S') . ' - ' . $cuenta["cue_nro_cuenta"];
        echo '<option value="' . $cuenta["cue_nro_cuenta"] . '">' . $valorCuenta . '</option>';
      }
      echo '</select>';
      echo '<div class="col-8 mensaje-container" id="msjError" style="margin: 1vh 0px;max-height: 50x; height: 50px;">';
      if (isset($msjError)) {
        echo '<div id="alerta" class="alert alert-danger role="alert" style="max-height: 40px; font-weight: 600;display: flex; align-items: center;justify-content: center;">' . $msjError . '</div>';
      }
      echo '</div>';
      echo '<button id="verMovimientos" type="submit" class="btn btn-primary" style="width:150px;">Ver</button>';
      echo '</form>';
      echo '</div>';
    } else {
      echo '<p style="color:blue; font-weight:700">No posee cuentas</p>';
    }
    ?>
    <br>
    <br>
    <h3>Movimientos</h3>
    <hr>
    <br>
    <?php
    if (isset($cuentaSeleccionada)) {
      //Si existen movimientos en la cuenta seleccionada, los muestro.
      if ($movimientosCuenta !== false && count($movimientosCuenta) !== 0) {
        echo '<table class="table table-hover text-center">';
        echo '<thead id="headTablaMovimientos">';
        echo '<tr>';
        echo '<th scope="col">#</th>';
        echo '<th scope="col">Fecha</th>';
        echo '<th scope="col">Nro. Transaccion</th>';
        echo '<th scope="col">Descripcion</th>';
        echo '<th scope="col">Importe</th>';
        echo '<th scope="col">Saldo</th>';
        echo '</tr> ';
        echo '</thead> ';
        echo '<tbody id="bodyTablaMovimientos">';
        //Se coloca el signo correcto de la moneda, en funcion del tipo de moneda de la cuenta seleccionada.
        $moneda = ($cuentaSeleccionada->getTipoMoneda() === "PESO" ? '$ ' : 'U$S ');
        foreach ($movimientosCuenta as $key => $movimiento) {
          echo '<tr>';
          echo '<td scope="col">' . $key . '</td>';
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
        echo '<p style="color:blue; font-weight:700">No posee movimientos asociados en la cuenta seleccionada.</p>';
      }
    } else {
      //Hasta que no se seleccione una cuenta, muestro el msj.
      echo '<p style="color:red; font-weight:700">Seleccione una cuenta para ver sus movimientos.</p>';
    }
    echo '</div>';
    echo '<br>';
    echo '<form method="">';
    echo '<button type="submit" formaction="home.php" class="btn btn-danger" style="width:150px;">Volver</button>';
    echo '</form>';
    echo ' <br> ';
    ?>
  </section>
</body>

</html>