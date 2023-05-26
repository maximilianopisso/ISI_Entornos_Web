<!DOCTYPE html>
<html>

<head>
    <title>Calculadora</title>
</head>

<body>
    <h1>Calculadora</h1>
    <form action="resultado.php" method="post">
        <label for="numero1">Primer número:</label>
        <input type="text" name="numero1" id="numero1" required><br>
        <br>
        <label for="numero2">Segundo número:</label>
        <input type="text" name="numero2" id="numero2" required><br>
        <br>
        <label for="operacion">Operación:</label>
        <!-- <select name="operacion" id="operacion" required> -->
        <button type="submit" name="operacion" value="suma">Suma</button>
        <button type="submit" name="operacion" value="resta">Resta</button>
        <button type="submit" name="operacion" value="multiplica">Multiplicación</button>
        <button type="submit" name="operacion" value="divide">División</button>
        <!-- </select><br> -->

        <!-- <input type="submit" value="Calcular"> -->
    </form>
</body>

</html>