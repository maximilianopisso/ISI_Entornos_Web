<?php

$alumnos = [
    array('nombre' =>'Maxi','apellido'=>'Pisso','nota'=>'8'),
];

$matriz = array(
    array('id' => '1', 'nombre' => 'carlos', 'email' => 'carlos@gmail.com'),
    array('id' => '2', 'nombre' => 'Pedro', 'email' => 'pedro@hotmail.com'),
    array('id' => '3', 'nombre' => 'José', 'email' => 'jose85@gmail.com'),
    array('id' => '4', 'nombre' => 'Juan', 'email' => 'juan@live.com')
);

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
            <h1>Nota Alumnos</h1>
            <!-- <h2><span class="bold">Enunciado:</span>Hacer una página que muestre las notas por alumno de cada uno de los 3 parciales del año.Cargar los datos en un arreglo PHP y mostrarlos con HTML en una tabla.</h2> -->
            
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Notas</th>
                </tr>
                <tr>
                    <td><?php echo  $alumnos[0]['nombre']; ?></td>
                    <td><?php echo  $alumnos[0]['apellido'];?></td>
                    <td><?php echo  $alumnos[0]['nota'];?></td>
                </tr>
            </table>            
        </section>
    </main>
    <footer>
        <!-- Contenido del pie -->
    </footer>

</body>

</html>