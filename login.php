<?php
require_once './app/classes/database.php';
require_once './app/classes/usuario.php';

if ($_POST !== array()) {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = (isset($_POST['email']) && is_string($_POST['email'])) ? trim($_POST['email']) : '';
    $password = (isset($_POST['password']) && is_string($_POST['password'])) ? trim($_POST['password']) : '';

    try {
      //Validaciones campos formularios login
      if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8 || strlen($password) > 15) {
        throw new Exception("Los campos ingresados email o password son incorrectos");
      }

      $database = new Database();
      //Validacion Resultado Busqueda en BD para el usuario
      $resultado = $database->getUsuarioByEmail($email);
      if (!$resultado) {
        $msjError = "El usuario no se encuentra registrado";
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

        $validacion = $usuario->validarUsuario($email, $password);

        if ($validacion === true) {
          //Inicia nueva session en PHP
          session_start();

          // Guarda los datos del usuario en la session PHP
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
}

// Para destruir el session de PHP
if (isset($_GET['logout'])) {
  if (session_start()) {
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
  <link rel="stylesheet" href="./css/style.css">
  <!-- REVISAR  -->
  <link rel="stylesheet" href="./css/styles2.css">

</head>

<body id="" style="background-image: linear-gradient(180deg, #fff9ff 20%, #f2e3ff 100%); height: 1200px;">
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
  <section id="inicio" class="container" style="margin-top: 0px;">
    <div class="row justify-content-center">
      <img id="icono" src="./images/login.svg" style="width: 150px; align-items: center; display: block;" class="" alt="Imagen alusoria a la necesidad de 
    realizar un logeo con usurio y contraseña para acceder a los servicios">
      <h1 style="text-align: center; margin: 0px" class="py-2">Ingresar a IBWallet</h1>
    </div>

    <!-- Formulario Login -->
    <div class="col-12 justify-content-center" style="margin: 10px auto; max-width:70%">
      <form id="formularioLogin" class="width: 100%" action="login.php" method="post">
        <div class="col-lg-8 col-md-8 col-sm-10" style="margin: 0px auto ;">
          <label for="inputEmail" class="form-label">Email</label>
          <input type="text" class="form-control" name="email" id="email">
        </div>

        <div class="col-lg-8 col-md-8 col-sm-10" style="margin: 0px auto;">
          <label for="inputPassword" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password">
        </div>

        <div class="col-12 mensaje-container" id="msjError" style="margin: 1vh 0px; max-height: 50x; height: 50px;">
          <?php
          if (isset($msjError) && !empty($msjError)) {
            echo '<div id="alerta" class="alert alert-danger role="alert" style="max-height: 40px; font-weight: 600;display: flex; align-items: center;justify-content: center;">' . $msjError . '</div>';
            echo '<script>
              setTimeout(function() {
                  document.getElementById("alerta").style.display = "none";
              }, 4000);
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