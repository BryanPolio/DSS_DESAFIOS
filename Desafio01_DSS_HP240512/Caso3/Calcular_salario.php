<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Caso 3 - Salario Neto</title>
    <style>
        body { background-color: #121212; color: #e0e0e0; font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #1e1e1e; padding: 20px; border-radius: 8px; border-top: 4px solid #3f51b5; }
        h2 { color: #7986cb; }
        .resultado { background-color: #2c2c2c; padding: 15px; border-left: 4px solid #3f51b5; margin-top: 15px; }
        .error { background-color: #3b1c1c; padding: 15px; border-left: 4px solid #ef5350; margin-top: 15px; color: #ef5350; }
        input[type="number"] { width: 100%; padding: 8px; margin-bottom: 10px; background: #333; color: white; border: 1px solid #555; }
        input[type="submit"] { background-color: #3f51b5; color: white; padding: 10px 15px; border: none; cursor: pointer; }
    </style>
</head>
<body>
<div class="container">
    <h2>Caso 3: Calcular el Salario Neto</h2>
    
    <form method="POST">
        <label>Ingrese el salario base ($):</label>
        <input type="number" step="0.01" name="salario" required>
        <input type="submit" value="Calcular Descuentos">
    </form>

    <?php
    function calcularSalarioNeto($salarioBase) {
        // Calculamos los descuentos fijos de ley
        $descuentoISSS = $salarioBase * 0.03;
        $descuentoAFP = $salarioBase * 0.075;
        
        // Empezamos a restarle al salario base
        $salarioLiquido = $salarioBase - $descuentoISSS - $descuentoAFP;

        // Revisamos si gana mas de $1000 para aplicar el otro descuento
        if ($salarioBase > 1000) {
            $rentaExtra = $salarioBase * 0.10;
            $salarioLiquido = $salarioLiquido - $rentaExtra;
        }

        return $salarioLiquido;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sueldoIngresado = $_POST['salario'];
        
        // Validando que el salario no sea negativo
        if ($sueldoIngresado < 0) {
            echo "<div class='error'><strong>Error:</strong> El salario base no puede ser un número negativo.</div>";
        } else {
            echo "<div class='resultado'>";
            echo "Salario Base ingresado: $" . number_format($sueldoIngresado, 2) . "<br>";
            echo "Salario Neto final: <strong>$" . number_format(calcularSalarioNeto($sueldoIngresado), 2) . "</strong>";
            echo "</div>";
        }
    }
    ?>
</div>
</body>
</html>