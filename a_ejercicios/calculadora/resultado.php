<?php
require_once 'calculadora.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero1 = $_POST['numero1'];
    $numero2 = $_POST['numero2'];
    $operacion = $_POST['operacion'];

    // Validar números ingresados
    if (!is_numeric($numero1) || !is_numeric($numero2)) {
        $resultado = ('Error: Los valores ingresados deben ser números.');
    } else {
        // Validar operación ingresada
        if (!in_array($operacion, ['suma', 'resta', 'multiplica', 'divide'])) {

            $resultado = 'Error: Operación no válida.';
        } else {

            $calculadora = new Calculadora($numero1, $numero2);

            // Realizar cálculo
            switch ($operacion) {
                case 'suma':
                    $resultado = $calculadora->sumar();
                    $operacionTexto = 'Suma';
                    break;
                case 'resta':
                    $resultado = $calculadora->restar();
                    $operacionTexto = 'Resta';
                    break;
                case 'multiplica':
                    $resultado = $calculadora->multiplicar();
                    $operacionTexto = 'Multiplicación';
                    break;
                case 'divide':
                    $resultado = $calculadora->dividir();
                    $operacionTexto = 'División';
                    break;
            }
        }
        // Mostrar resultado
        echo "<h1>Resultado</h1>";
        echo "<p>Operación: $operacionTexto</p>";
        echo "<p>Resultado: $resultado</p>";
        echo '<a href="index.php">Realizar otra operación</a>';
    }
}