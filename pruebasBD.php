 <?php

    // require_once "./app/classes/database.php";
    // require_once "./app/classes/usuario.php";
    // require_once "./app/classes/cuenta.php";
    // require_once "./app/classes/movimiento.php";
    // require_once "./app/classes/utils.php";

    // $database = new Database();
    // $filasAfectada = 0;
    // $resultado = $database->getUsuarioByEmail("%a");

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
     <title>IBWallet | Tu Billetera Digital | Realiza todas tus Operaciones</title>

     <!-- Boostrap -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

     <!-- CSS -->
     <link rel="stylesheet" href="./css/style.css">
     <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

 </head>

 <body id="" style="background-image: linear-gradient(180deg, #fff9ff 20%, #f2e3ff 100%); height: 1200px;">

     <!-- header 
    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid nav-container ">
                <a class="navbar-brand" href="#">IBWallet</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Menu Principal">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#inicio">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#nosotros">¿Que es IBWalllet?</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#servicios">Servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#ingreso">Ingresar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  " href="#contactos">Contacto</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>-->


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

            // var_dump($resultado);
            // foreach ($resultado[0] as $filas) {
            //     echo var_dump($filas) . '<br>' . '<br>' . '<br>';
            // }
            // // $capa1 = $resultado[0];
            // // echo "<br> <br>";
            // // var_dump($capa1);
            // // echo "<br> <br>";
            // foreach ($resultado[0] as $usuario) {
            //     echo "nombre: " . $usuario["user_nombre"] . "<br>";
            //     echo "apellido: " . $usuario["user_apellido"] . "<br>";
            //     echo "email: " . $usuario["user_email"] . "<br>";
            //     echo "habilitado: " . $usuario["user_habilitado"] . "<br><br>";
            //     $filasAfectada += 1;
            // }
            // echo "Registros: " . $filasAfectada . "<br><br>";

            // foreach ($resultado as $elemento) {
            //     // Iterar sobre los campos del elemento
            //     foreach ($elemento as $password => $valor) {
            //         // Verificar si el campo comienza con "user_"
            //         if (strpos($password, 'user_') === 0) {
            //             echo "$valor <br>";
            //         }
            //     }
            // }
            // foreach ($resultado as $level1) {
            //     foreach ($level1 as $level2) {
            //         echo "user_id: " . $level2["user_id"] . "<br>";
            //         echo "user_nombre: " . $level2["user_nombre"] . "<br>";
            //         // Mostrar el resto de los elementos...
            //         echo "<br>";
            //         $filasAfectada += 1;
            //     }
            // }
            // echo "FILAS: " . $filasAfectada . "<br>";
            ?>
     </section>

     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

 </body>

 </html>