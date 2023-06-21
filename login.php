<?php
require_once './app/classes/database.php';
require_once './app/classes/usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = isset($_POST['email']) ? trim($_POST['email']) : '';
  $password = isset($_POST['password']) ? trim($_POST['password']) : '';

  try {
    // Validaciones campos formularios login
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8 || strlen($password) > 15) {
      throw new Exception("Los campos ingresados email o password son incorrectos");
    }

    $databaseUser = new Database();
    // Validacion Resultado Busqueda en BD para el usuario
    $resultado = $databaseUser->getUsuarioByEmail($email);
    if (!$resultado) {
      $msjError = "El usuario no se encuentra registrado";
    } else {
      $user = $resultado[0];
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

      $validacion = $usuario->validarUsuario($email, $password);

      if ($validacion === true) {
        // Inicia nueva sesión en PHP
        session_start();

        // Guarda los datos del usuario en la sesión PHP
        $_SESSION['user'] = array(
          'id' => $usuario->getId(),
          'nombre' => $usuario->getNombre(),
          'apellido' => $usuario->getApellido(),
          'sexo' => $usuario->getSexo(),
        );

        // Redirige a la home del usuario
        header('Location: home.php', true, 302);
        exit();
      }
    }
  } catch (Exception $e) {
    $msjError = $e->getMessage();
  }
}

// Para destruir la sesión de PHP
if (isset($_GET['logout'])) {
  if (session_start()) {
    $params = session_get_cookie_params();
    setcookie(
      session_name(),         // name
      '',                     // value
      1,
      $params['path'],
      $params['domain'],
      $params['secure'],
      $params['httponly']                     // expire     
    );
    session_destroy();
  }
  header("Location: login.php");
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
  <meta property="og:title" content="Login | IBWallet | Tu Billetera Digital" />
  <meta property="og:description" content="IBWallet es desarrollo de comercio electrónico que permite que los pagos
    y transferencias de dinero se hagan a través de Internet" />
  <meta property="og:image" content="https://ibwallet.000webhostapp.com/images/login.svg" />

  <!-- Titulo -->
  <title>Login | IBWallet | Tu Billetera Digital </title>

  <!-- Boostrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <!-- CSS -->
  <link rel="stylesheet" href="./css/appStyle.css">

</head>

<body id="body-login">
  <!-- header-->
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
              <a class="nav-link" href="./index.html">Inicio</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Login -->
  <section id="login" class="container" style="margin-top: 0px;">
    <div class="row justify-content-center">
      <img id="icono" src="./images/login.svg" alt="Imagen alusoria a la necesidad de 
    realizar un logeo con usuario y contraseña para acceder a los servicios">
      <h1 style="text-align: center; margin: 0px" class="py-2">Ingresar a IBWallet</h1>
    </div>

    <!-- Formulario Login -->
    <div class="col-12 justify-content-center" style="margin: 5px auto; max-width:60%">
      <form id="formularioLogin" class="width: 100%" action="login.php" method="post">
        <div class="col-lg-8 col-md-8 col-sm-10" style="margin: 0px auto ;">
          <label for="email" class="form-label">Email</label>
          <input type="text" class="form-control" name="email" id="email">
        </div>

        <div class="col-lg-8 col-md-8 col-sm-10" style="margin: 10px auto;">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password">
        </div>

        <div class="col-12 mensaje-container my-2" id="msjError" style="height: 35px; max-height: 35px;">
          <?php
          if (isset($msjError) && !empty($msjError)) {
            echo '<div id="alerta" class="alert alert-danger" role="alert" style="height:25px; max-height: 25px; font-weight: 600;display: flex; align-items: center;justify-content: center;">' . $msjError . '</div>';
            echo '<script>
              setTimeout(function() {
                  document.getElementById("alerta").style.display = "none";
              }, 2000);
          </script>';
          }
          ?>
        </div>

        <div class="col-12 d-flex justify-content-center" id="boton-conteiner">
          <button id="boton" type="submit" class="btn btn-primary" style="background-color: #8842c1; width: 200px;height:50px; font-weight: 600;">Iniciar Sesión</button>
        </div>
      </form>
    </div>
  </section>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- JScript -->
  <script src="./js/login.js"></script>
</body>

</html>