<?php
function mostrar_error($mensaje) {
    echo '<p>' . $mensaje . '</p>';
    echo '<script>window.history.back()</script>';
    exit();
}
  // Validar que se ingresaron todos los datos requeridos
function validaCamposRequeridos($nombre, $direccion, $telefono){
    if (empty($nombre) || empty($direccion) || empty($telefono)) {
        mostrar_error("Por favor, complete todos los campos.");
    }
}
 
function validarCampo($campo, $min, $max){
// Validar que los datos ingresados son válidos
    if (mb_strlen($campo) >= $min && mb_strlen($campo)<=$max){
         return true;
    }else{
         mostrar_error("Por favor, el valor $campo supera los limites ");
    }
}
// Función para mostrar un mensaje de error y recargar los datos en el formulario