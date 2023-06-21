 <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = (isset($_POST['clave']) && is_string($_POST['clave'])) ? trim($_POST['clave']) : '';

        $secret_key = "IBwallet"; // Secret key for HMAC
        $passwordCifrada = hash_hmac('sha256', $password, $secret_key);
    }

    ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>

     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <!-- Meta Tags -->
     <meta name="description" content=" IBWallet es desarrollo de comercio electrónico que permite que los pagos
         y transferencias de dinero se hagan a través de Internet." />
     <meta name="keywords" content="desarrolo web, dinero, transferencia, deposito, IBWallet, tarjeta bancaria, tarjeta debito, tarjeta credito, transferencia online, finanzas, operaciones financieras, operaciones, credito, debito," />

     <!-- Opengraph -->
     <meta property="og:title" content="IBWallet | Tu Billetera Digital" />
     <meta property="og:description" content="IBWallet es desarrollo de comercio electrónico que permite que los pagos
        y transferencias de dinero se hagan a través de Internet" />
     <meta property="og:image" content="https://ibwallet.000webhostapp.com/images/IBwallet.svg" />

     <!-- Titulo -->
     <title>Cifrado Claves | Tu Billetera Digital</title>

     <!-- Boostrap -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

     <!-- CSS -->
     <link rel="stylesheet" href="./css/style.css">
 </head>

 <body>

     <!-- inicio -->
     <section class="container">
         <br>
         <h1>Pruebas BD</h1>
         <br>
         <h2>Cifrado Password</h2>
         <?php
            echo '<form action="pruebasBD.php" method="post">';
            echo '<label for="" style="font-weight: 600;">Ingresar Clave</label>';
            echo '<br>';
            echo '<input type="text" name="clave" id="clave" class="form-control" style="width: 500px;">';
            echo '<br>';
            echo '<button id="btn-transferir" type="submit" class="btn btn-primary" style="width:150px;">Cifrar Clave</button>';
            echo '<br>';
            echo '</form>';
            if (isset($passwordCifrada) && $password !== "") {
                echo '<br>';
                echo '<input type="text" class="form-control" style="width: 700px;"name="claveCifrada" id="claveCifrada" value=' . $passwordCifrada  . '>';
            }

            ?>
     </section>

     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

 </body>

 </html>