<?php
require_once "./php/classes/database.php";
require_once "./php/classes/usuario.php";
require_once "./php/classes/cuenta.php";
require_once "./php/classes/movimiento.php";
require_once "./php/classes/utils.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  try {
    $user_id = (isset($_GET['user_id']) && is_string($_GET['user_id'])) ? trim($_GET['user_id']) : '';
    $database = new Database();
    $resultadoGet = $database->getUsuarioById($user_id);
    if (!$resultadoGet[0]) {
      throw new Exception("Usuario no existe", 202);
    } else {
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
    if (!$resultadoGet) {
      throw new Exception("Cuenta no existe", 202);
    } else {
      $cuentaGet = $resultadoGet;
    }
  } catch (Exception $e) {
    Utils::alert($e);
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    // $cuentaOrigen = (isset($_POST['cuentaOrigen']) && is_string($_POST['cuentaOrigen'])) ? trim($_POST['cuentaOrigen']) : '';
    // $cuentaDestino = (isset($_POST['$cuentaDestino']) && is_string($_POST['$cuentaDestino'])) ? trim($_POST['$cuentaDestino']) : '';
    // $importe = (isset($_POST['$importe']) && is_string($_POST['$importe'])) ? $_POST['$importe'] : '';
    $NroCuentaOrigen = $_POST['cuentaOrigen'];
    $NroCuentaDestino = $_POST['cuentaDestino'];
    $importe = $_POST['importe'];

    // Ahora puedes utilizar los valores capturados para realizar las acciones necesarias, como realizar la transferencia o procesar la información.

    // Ejemplo de cómo imprimir los valores capturados:
    // echo "Cuenta origen: " . $NroCuentaOrigen . "<br>";
    // echo "Cuenta destino: " . $NroCuentaDestino . "<br>";
    // echo "Importe: " . $importe . "<br>";
    // var_dump($NroCuentaOrigen, $NroCuentaDestino, $importe);
    // $NroCuentaOrigen = floatval($NroCuentaOrigen);
    // $NroCuentaDestino = floatval($NroCuentaDestino);

    if ($NroCuentaOrigen === $NroCuentaDestino) {
      throw new Exception("Las cuentas tienen que ser distintas", 300);
    }

    if (is_numeric($importe)) {
      $importe = floatval($importe);
    } else {
      throw new Exception("El importe no es valido", 300);
    }

    if (!is_string($NroCuentaOrigen) || !is_string($NroCuentaDestino) || !is_float($importe)) {
      throw new Exception("Los valores introducidos no son validos", 300);
    };

    $database = new Database();
    $datosCuentaOrigen = $database->getCuentabyNroCuenta($NroCuentaOrigen);
    $database->openConection();
    $datosCuentaDestino = $database->getCuentabyNroCuenta($NroCuentaDestino);

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
    // var_dump($cuentaOrigen);
    // echo "<br>";
    // echo "<br>";
    // var_dump($cuentaDestino);


    if ($cuentaOrigen->getTipoMoneda() !== $cuentaDestino->getTipoMoneda()) {
      throw new Exception("Las cuentas deben tener el mismo tipo de moneda", 300);
    } else {
      $cuentaOrigen->transferirImporte($cuentaDestino, $importe);
    }
  } catch (Exception $e) {
    Utils::screenMsj($e);
    Utils::alert($e->getMessage());
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

  <!-- Iconos Redes Sociales -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Para importar iconos redes sociales -->

  <!-- Boostrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <!-- CSS -->
  <link rel="stylesheet" href="./css/style.css">

  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>


</head>

<body id="" style="background-image: linear-gradient(180deg, #fff9ff 20%, #f2e3ff 100%); height: 700px;">
  <!-- header -->
  <!-- <header class="fixed-top">
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
  </header> -->

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
    if (isset($cuentaGet) && count($cuentaGet) !== 0) {
      echo '<div id="transferencias" class="col-12 pt-2">';
      echo '<form action="transferencias.php" method="post">';
      echo '<label for="origen" style="font-weight: 600;">Cuenta origen:</label><br>';
      echo '<select class="form-control" style="width: 500px;" name="cuentaOrigen">';
      echo '<option value="seleccionar" selected>Seleccionar...</option>';
      foreach ($cuentaGet as $cuenta) {
        $valorCuenta = $cuenta["cue_tipo_cuenta"] . ' - ' . (($cuenta["cue_tipo_moneda"] === "PESO") ? '$' : 'U$S') . ' - ' . $cuenta["cue_nro_cuenta"];
        echo '<option value="' . $cuenta["cue_nro_cuenta"] . '">' . $valorCuenta . '</option>';
      }
      echo '</select><br>';
      echo '<label for="origen" style="font-weight: 600;">Cuenta Destino:</label><br>';
      echo '<select class="form-control" style="width: 500px;" name="cuentaDestino">';
      echo '<option value="seleccionar" selected>Seleccionar...</option>';
      foreach ($cuentaGet as $cuenta) {
        $valorCuenta = $cuenta["cue_tipo_cuenta"] . ' - ' . (($cuenta["cue_tipo_moneda"] === "PESO") ? '$' : 'U$S') . ' - ' . $cuenta["cue_nro_cuenta"];
        echo '<option value="' . $cuenta["cue_nro_cuenta"] . '">' . $valorCuenta . '</option>';
      }
      echo '</select><br>';
      echo '<label for="importe" style="font-weight: 600;">Importe:</label>';
      echo '<input type="text" name="importe" class="form-control" id="importe" style="width: 500px;"><br>';
      echo '<button id="btn-transferir" type="submit" class="btn btn-primary" style="width:150px;">Transferir</button>';
      echo '</form>';
    }

    echo '<br>';
    echo '<form method="">';
    echo '<button type="submit" formaction="home.php" class="btn btn-danger" style="width:150px;">Volver</button>';
    echo '</form>';
    echo ' <br> ';
    echo '</div>'

    ?>
  </section>
</body>

</html>