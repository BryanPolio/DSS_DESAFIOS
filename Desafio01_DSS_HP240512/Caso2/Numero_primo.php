<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Caso 2 - Números Primo</title>
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
    <h2>Caso 2: Validar si el es Número Primo</h2>
    
    <form method="POST">
        <label>Ingrese un número entero:</label>
        <input type="number" name="numero" required>
        <input type="submit" value="Verificar">
    </form>

    <?php
    function esNumeroPrimo($numero) {
        // Por regla general el 1 y los negativos no son primos
        if ($numero <= 1) {
            return false;
        }

        // Asumiendo de entrada que el numero si es primo
        $esPrimo = true; 

        // Empezamos a intentar dividir desde el 2 en adelante
        for ($i = 2; $i < $numero; $i++) {
            // Si el residuo da 0, significa que encontramos otro divisor
            if ($numero % $i == 0) {
                $esPrimo = false;
                break; // Detengo el ciclo porque ya no tiene sentido seguir buscando
            }
        }

        return $esPrimo;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $numeroIngresado = $_POST['numero'];
        
        // Validamos que no metan negativos ni cero
        if ($numeroIngresado <= 0) {
            echo "<div class='error'><strong>Error:</strong> Por favor ingrese un número mayor a cero.</div>";
        } else {
            echo "<div class='resultado'>";
            echo "Número a evaluar: $numeroIngresado <br>";
            
            if (esNumeroPrimo($numeroIngresado)) {
                echo "Resultado: <strong>Es primo</strong>";
            } else {
                echo "Resultado: <strong>No es primo</strong>";
            }
            echo "</div>";
        }
    }
    ?>
</div>
</body>
</html>