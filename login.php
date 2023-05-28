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
  <!-- FIN REVISAR  -->
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>

  <!-- JScript -->
  <!-- <script src="./js/classes/usuario.js" defer></script> -->
  <!-- <script src="./js/classes/movimiento.js" defer></script> -->
  <script src="./js/driverLocalStore.js" defer></script>
  <script src="./js/login.js" defer></script>

</head>

<body>
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
              <a class="nav-link" href="#contactos">Contacto</a>
            </li>
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
    <div class="row justify-content-center" styles="width: 200px">
      <img id="icono" src="./images/login.svg" loading="lazy" style="width: 150px; align-items: center; display: block;" class="" alt="Imagen alusoria a la necesidad de 
    realizar un logeo con usurio y contraseña para acceder a los servicios">
      <h1 style="text-align: center; margin: 0px" class="py-2">Ingresar a IBWallet</h1>
    </div>
    <div class="col-12 justify-content-center" style="margin: 10px auto;">
      <!-- <div class="col-lg-12 col-md-12 col-sm-12 justify-content-center"> -->

      <!-- FORMULARIO LOGIN -->
      <form id="formularioLogin" class="width: 100%" action="home.php" method="post">
        <!-- <form id="formularioLogin" class="width: 100%" action=""> -->

        <div class="col-lg-8 col-md-8 col-sm-12" style="margin: 0px auto ;">
          <label for="inputEmail" class="form-label">Email</label>
          <input type="text" class="form-control" name="email">
        </div>

        <div class="col-lg-8 col-md-8 col-sm-12" style="margin: 0px auto ;">
          <label for="inputPassword" class="form-label">Password</label>
          <input type="text" class="form-control" name="password">
        </div>

        <div class="col-12 mensaje-container">
          <span id="msjerror"></span>
        </div>

        <div class="col-12 d-flex justify-content-center" id="boton-conteiner">
          <button id="boton" type="submit" class="btn btn-primary" style="background-color: #8842c1; width: 150px ; font-weight: 600;">Ingresar</button>
        </div>
      </form>


    </div>
    </div>
  </section>

  <!-- Footer -->
  <footer id="contactos">
    <div class="row conteiner-fluid contactos-container">
      <div class="col-sm-12 col-md-6 col-lg-6 redessociales-container">
        <p class="titulos">Nuestras Redes</p>
        <a class="fa fa-facebook" href="https:\\facebook.com"></a>
        <a class="fa fa-twitter" href="https:\\twitter.com"></a>
        <a class="fa fa-instagram" href="https:\\instagram.com"></a>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6  contactos-container">
        <p class="titulos">Escribinos</p>
        <address>
          <p>contacto@ibwallet.com.ar</p>
        </address>
      </div>
    </div>
    <p class="leyenda">Copyright © 2021 IBWallet S.A. Todos los derechos reservados</p>
    <div class="certificaciones">
      <p>
        <a href="https://jigsaw.w3.org/css-validator/check/referer">
          <img style="border:0;width:88px;height:31px" src="https://jigsaw.w3.org/css-validator/images/vcss" alt="¡CSS Válido!" />
        </a>
      </p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>

</html>