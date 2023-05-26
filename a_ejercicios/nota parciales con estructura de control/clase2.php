<?php

$alumnos = [ 
   array('nombre' =>'Maxi','apellido'=>'Pisso','nota'=>'8'),
   array('nombre' =>'Ana','apellido'=>'Perez','nota'=>'9'),
   array('nombre' =>'Pedro','apellido'=>'Ramirez','nota'=>'4'),
   array('nombre' =>'Tamara','apellido'=>'Yunnissi','nota'=>'7'),
];

$matriz = array(
    array('id' =>  1, 'nombre' => 'carlos', 'email' => 'carlos@gmail.com'),
    array('id' =>  2, 'nombre' => 'Pedro', 'email' => 'pedro@hotmail.com'),
    array('id' => 3, 'nombre' => 'José', 'email' => 'jose85@gmail.com'),
    array('id' => 4, 'nombre' => 'Juan', 'email' => 'juan@live.com')
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
            <h2>Tabla cargada con For</h2>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Notas</th>
                </tr>

                <?php
                    for ($i = 0; $i < count($alumnos); $i++) { 
                        echo "<tr>","<td>", $alumnos[$i]['nombre'],"</td>"; 
                        echo "<td>", $alumnos[$i]['apellido'],"</td>";
                        echo "<td>", $alumnos[$i]['nota'],"</td>","</tr>";
                    }
                ?>
            </table>
            <h2>Tabla cargada con While</h2>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Notas</th>
                </tr>
                <?php
                    $index = 0;
                        while ($index < count($alumnos) ) {
                        echo "<tr>","<td>", $alumnos[$index]['nombre'],"</td>"; 
                            echo "<td>", $alumnos[$index]['apellido'],"</td>";
                            echo "<td>", $alumnos[$index]['nota'],"</td>","</tr>";
                            $index++;   
                        }           
                    ?>
            </table>
            <h2>Tabla cargada con ForEach</h2>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Notas</th>
                </tr>

                <?php   
                        foreach ($alumnos as $alumno) {
                             echo "<tr>","<td>", $alumno['nombre'],"</td>"; 
                            echo "<td>", $alumno['apellido'],"</td>";
                            echo "<td>",$alumno['nota'],"</td>","</tr>";
                        }
                    ?>
            </table>
        </section>
    </main>
    <footer>
        <!-- Contenido del pie -->
    </footer>

</body>

</html>