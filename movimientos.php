<?php
require_once "./php/classes/database.php";
require_once "./php/classes/usuario.php";
require_once "./php/classes/cuenta.php";
require_once "./php/classes/movimiento.php";
require_once "./php/classes/utils.php";
//MOVIMIENTOS !!!

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $user_id = (isset($_GET['user_id']) && is_string($_GET['user_id'])) ? trim($_GET['user_id']) : '';
  // Utils::alert($nroCuenta);
  $database = new Database();
  $resultadoGet = $database->getUsuarioById($user_id);
  if (!$resultadoGet[0]) {
    throw new Exception("Usuario no existe", 202);
  } else {
    $userAuxGet = $resultadoGet[0];

    $usuario = new Usuario(
      $resultadoGet[0]["user_id"],
      $resultadoGet[0]["user_nombre"],
      $resultadoGet[0]["user_apellido"],
      $resultadoGet[0]["user_email"],
      $resultadoGet[0]["user_password"],
      $resultadoGet[0]["user_contacto"],
      $resultadoGet[0]["user_sexo"],
      $resultadoGet[0]["user_intentos"],
      $resultadoGet[0]["user_habilitado"],
    );
  }
  // $validacionGet = $usuarioGet->validarUsuario($email, $password);
  $resultadoGet = $usuario->obtenerCuentas();
  // var_dump($resultadoGet);
  // echo "<br>";
  // echo "<br>";
  // var_dump($resultadoGet[0]);
  if (!$resultadoGet) {
    throw new Exception("Cuenta no existe", 202);
  } else {
    $cuentaGet = $resultadoGet;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  global $usuario;
  $nroCuenta = (isset($_POST['selectCuenta']) && is_string($_POST['selectCuenta'])) ? trim($_POST['selectCuenta']) : '';
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
    $datosCuenta[0]["cue_saldo"],
  );
  $movimientosCuenta = $cuentaSeleccionada->obtenerMovimientos();
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
    if (isset($cuentaGet) && count($cuentaGet) !== 0) {
      echo '<div id="movimientos" class="col-12 pt-4">';
      echo '<form action="movimientos.php" method="post">';
      echo '<label for="" style="font-weight: 600;">Seleccioná tu cuenta:</label>';
      echo '<br>';
      echo '<select class="form-control" style="width: 500px;" name="selectCuenta">';
      echo '<option value="selected" selected>Seleccionar...</option>';
      foreach ($cuentaGet as $cuenta) {
        $valorCuenta = $cuenta["cue_tipo_cuenta"] . ' - ' . (($cuenta["cue_tipo_moneda"] === "PESO") ? '$' : 'U$S') . ' - ' . $cuenta["cue_nro_cuenta"];
        echo '<option value="' . $cuenta["cue_nro_cuenta"] . '">' . $valorCuenta . '</option>';
      }
      echo '</select>';
      echo '<br>';
      echo '<button id="verMovimientos" type="submit" class="btn btn-primary" style="width:150px;">Ver</button>';
      echo '</form>';
      echo '</div>';
    } else {
      // echo '<p style="color:blue; font-weight:700">No posee cuentas</p>';
    }
    ?>
    <br>
    <br>
    <h3>Movimientos</h3>
    <hr>
    <br>
    <?php
    if (isset($nroCuenta)) {
      if (isset($movimientosCuenta) && count($movimientosCuenta) !== 0) {
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
        $moneda = (isset($cuentaSeleccionada) && ($cuentaSeleccionada->getTipoMoneda() === "PESO") ? '$ ' : 'U$S ');
        foreach ($movimientosCuenta as $key => $movimiento) {
          echo '<tr>';
          echo '<td scope="col">' . $key . '</td>';
          echo '<td scope="col">' . $movimiento["mov_fecha"] . '</th>';
          echo '<td scope="col">' . $movimiento["mov_nro_transaccion"] . '</th>';
          echo '<td scope="col">' . $movimiento["mov_descripcion"] . '</th>';
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
        echo '<p style="color:blue; font-weight:700">No posee movimientos asociados en la cuenta seleccionada.</p>';
      }
    } else {
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