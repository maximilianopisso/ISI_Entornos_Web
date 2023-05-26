 <?php
 require_once 'procesar_formulario.php';

 if($_SERVER['REQUEST_METHOD'] === 'POST'){

 $nombre = (isset($_POST['nombre']) && is_string($_POST['nombre'])) ? trim($_POST['nombre']) : '';
 $direccion = (isset($_POST['direccion']) && is_string($_POST['d'])) ? trim($_POST['d']) : '';
 $telefono = (isset($_POST['telefono']) && is_string($_POST['telefono'])) ? trim($_POST['telefono']) : '';

 }
 ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
 </head>

 <body>
     <form method="POST" action="index.php">
         <label for="nombre">Nombre:</label>
         <input type="text" id="nombre" name="nombre">

         <label for="direccion">Dirección:</label>
         <input type="text" id="direccion" name="direccion">

         <label for="telefono">Teléfono:</label>
         <input type="text" id="telefono" name="telefono">

         <input type="submit" value="Enviar">
     </form>

 </body>

 </html>