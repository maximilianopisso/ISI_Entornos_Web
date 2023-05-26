<?php

$nombre = 'Calzavara S.R.L';
$descripcion = 'La mejor ferreteria de todas';
$dirección = 'Av. Francia 1352';
$localidad = 'Rosario';
$codigoPostal = '2000';
$pais = 'Argentina';
$telefono = '3415586548';
$email = 'ventas@calzavarasrl.com.ar';

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Página de empresa</title>
</head>

<body>
    <main>
        <section id="contenido">
            <h1>Dato - Empresa</h1>
            <!-- <h2><span class="bold">Enunciado:</span>Hacer una página que muestre las notas por alumno de cada uno de los 3 parciales del año.Cargar los datos en un arreglo PHP y mostrarlos con HTML en una tabla.</h2> -->
            <p>Nombre:
                <?php echo "$nombre"; ?>
            </p>
            <p>Descripción:
                <?php echo "$descripcion"; ?>
            </p>
            <p>Dirección:
                <?php echo "$dirección, $localidad, ($codigoPostal), $pais"; ?>
            </p>
             <p>Teléfono:
                <?php echo "$telefono"; ?>
            </p>
            <p>Contacto:
                <?php echo "$email"; ?>
            </p>
        </section>
    </main>
    <footer>
        <!-- Contenido del pie -->
    </footer>

</body>

</html>