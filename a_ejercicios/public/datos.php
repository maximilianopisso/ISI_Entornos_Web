<?php
$nombre = (isset($_POST['nombre']) && is_string($_POST['nombre'])) ? $_POST['nombre'] : '';
$email = (isset($_POST['email']) && is_string($_POST['email'])) ? $_POST['email'] : '';
$sexo = (isset($_POST['sexo']) && is_string($_POST['sexo'])) ? $_POST['sexo'] : '';
$ubicacion = (isset($_POST['ubicacion']) && is_string($_POST['ubicacion'])) ? $_POST['ubicacion'] : '';
$servicios = (isset($_POST['servicios']) && is_string($_POST['servicios'])) ? $_POST['servicios'] : array();
$mensaje = (isset($_POST['mensaje']) && is_string($_POST['mensaje'])) ? $_POST['mensaje'] : '';
$aceptaCondiciones = (isset($_POST['aceptaCondiciones']) && is_string($_POST['aceptaCondiciones'])) ? $_POST['aceptaCondiciones'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de datos - PHP</title>
</head>
<body>
    <h1>Datos Enviados</h1>
    <p><?php echo 'Cantidad Datos:',count($_POST);?></p>
    <p><?php echo 'Nombre: ',htmlspecialchars($nombre,ENT_QUOTES);?></p>
    <p><?php echo 'Email: ',htmlspecialchars($email,ENT_QUOTES);?></p>
    <p><?php echo 'Sexo: ',htmlspecialchars($sexo,ENT_QUOTES);?></p>
    <p><?php echo 'Ubicacion: ',htmlspecialchars($ubicacion,ENT_QUOTES);?></p>
    <p><?php echo 'Servicios: ',htmlspecialchars(implode(', ',$servicios),ENT_QUOTES);?></p>
    <p><?php echo 'Mensaje: ',htmlspecialchars($mensaje,ENT_QUOTES);?></p>
    <p><?php echo '¿Acepta las condiciones?: ',htmlspecialchars($aceptaCondiciones,ENT_QUOTES);?></p>
</body>
</html>