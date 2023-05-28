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
    <div id="transferencias" class="col-12 pt-4">
      <form action="">
        <label for="origen" style="font-weight: 600;">Cuenta origen:</label>
        <br>
        <select class="form-control" style="width: 500px;" name="cuentas" id="cuentaOrigen">
          <option selected>Seleccionar...</option>
          <option value="">CA-$-00754654654645454</option>
          <option value="">CA-U$S-0078884223625555</option>
          <option value="">CC-$-0073884555545454</option>
        </select>
        <br>
        <label for="destino" style="font-weight: 600;">Cuenta destino:</label>
        <br>
        <select class="form-control" style="width: 500px;" name="cuentas" id="cuentaDestino">
          <option selected>Seleccionar...</option>
          <option value="">CA-$-00754654654645454</option>
          <option value="">CA-U$S-0078884223625555</option>
          <option value="">CC-$-0073884555545454</option>
        </select>
        <br>
        <label for="importe" style="font-weight: 600;">Importe:</label>
        <input type="" class="form-control" id="importe" style="width: 500px;">
        <br>
        <button id="btn-transferir" type="submit" href="" class="btn btn-primary" style="width:150px;">Transferir</button>
        <button id="btn-volver" type="submit" class="btn btn-danger" style="width:150px;"><a href="home.php" style="color: white; text-decoration: none; width: 200px;">Volver</a></button>
      </form>
  </section>
</body>

</html>