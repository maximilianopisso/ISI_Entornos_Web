<?php
require_once 'php\classes\database.php';

$database = new Database();
$filasAfectada = 0;
$resultado = $database->selectUsuariosByName("%a");
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

<body>

    <!-- header -->
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
    </header>

    <main>
        <!-- inicio -->
        <section id="inicio" class="container">
            <h1>Pruebas BD</h1>
          

                <?php
                // var_dump($resultado);
                foreach ($resultado[0] as $filas) {
                    echo var_dump($filas) . '<br>' . '<br>' . '<br>';
                }
                // $capa1 = $resultado[0];
                // echo "<br> <br>";
                // var_dump($capa1);
                // echo "<br> <br>";
                foreach ($resultado[0] as $usuario) {
                    echo "nombre: " . $usuario["user_nombre"] . "<br>";
                    echo "apellido: " . $usuario["user_apellido"] . "<br>";
                    echo "email: " . $usuario["user_email"] . "<br>";
                    echo "habilitado: " . $usuario["user_habilitado"] . "<br><br>";
                    $filasAfectada += 1;
                }
                echo "Registros: " . $filasAfectada . "<br><br>";
                // foreach ($resultado as $elemento) {
                //     // Iterar sobre los campos del elemento
                //     foreach ($elemento as $clave => $valor) {
                //         // Verificar si el campo comienza con "user_"
                //         if (strpos($clave, 'user_') === 0) {
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

        <!-- nosotros -->
        <section id="nosotros" class="container">
            <h2>¿Que es IBWallet?</h2>
            <div class="row nosotros-container">
                <div class="col-sm-12 col-md-12 col-lg-6 text-container">
                    <p>
                        Para personas acostumbradas a realizar compras a través de Internet, tener una billetera
                        electrónica puede facilitarle la vida.
                    </p>
                    <p>Así es como surge <strong>IBwallet</strong>, una plataforma
                        que
                        le permitirá a usted administrar su dinero de
                        forma rápida y segura, vincular sus tarjetas bancarias y realizar transferencias de forma simple
                        en
                        cualquier momento.
                    </p>
                    <p>
                        No esperes más, y crea tu cuenta billetera electrónica en IBwallet y comenzá a disfrutar de sus
                        beneficios.
                    </p>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="img-nosotros">
                        <div data-aos="fade-right" data-aos-duration="1500">
                            <img src="./images/nosotros.svg" loading="lazy" class="img-fluid" alt="Foto representativa de una billetera virtual, son dos celulares
                            que representado una transaccion bancaria ">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- servicios   -->
        <section id="servicios" class="container">
            <h2>Servicios</h2>
            <div class="row servicios-container">
                <div class="col-sm-12 col-md-12 col-lg-4 item-servicios">
                    <div class="card">
                        <div data-aos="zoom-in" data-aos-duration="1500">
                            <img class="img-fluid" loading="lazy" src="./images/serv3-deposito.svg" alt="Imagen representativa de un deposito 
                            bancario a alguna de las cuentas que se registrasen en la aplicacion">
                        </div>
                        <div class="card-body">
                            <p class="card-text ">Recibí dinero desde otras cuentas</p>
                        </div>
                    </div>

                </div>

                <div class="col-sm-12 col-md-12 col-lg-4 item-servicios">
                    <div class="card">
                        <div data-aos="zoom-in" data-aos-duration="1500">
                            <img class="img-fluid" loading="lazy" src="./images/serv2-creditcard.svg" alt="Imagen representativa de una tarjeta bancaria, representando 
                        que la aplicacion se pueden asosciar tarjetas bancarias">
                        </div>
                        <div class="card-body">
                            <p class="card-text">Asociá todas tus tarjetas bancarias</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-4 item-servicios">
                    <div class="card">
                        <div data-aos="zoom-in" data-aos-duration="1500">
                            <img class="img-fluid " loading="lazy" src="./images/serv1-transferencias.svg" alt="Imagen representativa que muestra un celular realizando
                        un pago a traves de lo que seria la aplicacion">
                        </div>
                        <div class="card-body">
                            <p class="card-text">Realizá transferencias desde tus cuentas en un solo lugar
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- portada     -->
        <section id="ingreso">
            <div class="container">
                <div class="row">
                    <div class="col-12 carrusel-container">
                        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Imagen 1 : Recibir Dinero"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Imagen 2 : Asociar Tarjeta"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Imagen 3 : Transacciones"></button>
                            </div>

                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="item-container">
                                        <img src="./images/carrusel-dinero.svg" loading="lazy" alt="Imagen representativa de fajos de dinero, 
                                        asociando la idea de recibir dinero en tu cuentas">

                                        <div class="carousel-text">
                                            <h2>Recibí tu Dinero</h2>
                                            <p>Crea tu propia IBWallet y comenzá a
                                                recibir tu dinero en tu billetera digital </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-item ">
                                    <div class="item-container">
                                        <img src="./images/carrusel-tarjeta.svg" loading="lazy" alt="Imagen representativa de una billetera
                                        sacando una tarjeta bancaria, asociando la idea de poder asociarlas en tu cuentas">

                                        <div class="carousel-text">
                                            <h2>Asociá tus Tarjetas</h2>
                                            <p>Podes asociar tus tarjetas bancarias y efectuar
                                                transacciones con todas ellas</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-item">
                                    <div class="item-container">
                                        <img src="./images/carrusel-operaciones.svg" loading="lazy" alt="Imagen representativa de una billetera sacando una tarjeta bancaria, 
                                        asociando la idea de poder asociarlas en tu cuentas">

                                        <div class="carousel-text">
                                            <h2>Realizá todas tus Operaciones</h2>
                                            <p>Con IBwallet, vas a poder realizar todo tipo de operaciones desde tus
                                                cuentas</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <a href="login.html" class="boton">Ingresar</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- footer   -->
    <footer id="contactos">

        <div class="row conteiner-fluid contactos-container">
            <div class="col-sm-12 col-md-6 col-lg-6   redessociales-container">
                <p class="titulos">Nuestras Redes</p>
                <a class="fa fa-facebook" href="https://facebook.com"></a>
                <a class="fa fa-twitter" href="https://twitter.com"></a>
                <a class="fa fa-instagram" href="https://instagram.com"></a>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 contactos-container">
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