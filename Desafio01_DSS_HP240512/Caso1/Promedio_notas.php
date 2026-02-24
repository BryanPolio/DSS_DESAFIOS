<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Caso 1 - Promedio de notas</title>
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
    <h2>Caso 1: Calcular Promedio Notas</h2>
    
    <form method="POST">
        <label>Nota 1:</label>
        <input type="number" step="0.01" name="nota1" required>
        
        <label>Nota 2:</label>
        <input type="number" step="0.01" name="nota2" required>
        
        <label>Nota 3:</label>
        <input type="number" step="0.01" name="nota3" required>
        
        <label>Nota 4:</label>
        <input type="number" step="0.01" name="nota4" required>
        
        <input type="submit" value="Calcular Promedio">
    </form>

    <?php
    function calcularPromedioNotas($notas) {
        $totalNotas = count($notas);
        
        // Verifica si no mandaron notas para evitar errores matematicos
        if ($totalNotas == 0) {
            return 0; 
        }

        // Llevamos la cuenta de la suma total
        $suma = 0;
        
        // Pasamos por cada nota del arreglo y la vamos sumando
        for ($i = 0; $i < $totalNotas; $i++) {
            $suma = $suma + $notas[$i]; 
        }

        // Sacamos el promedio dividiendo entre la cantidad de notas
        $promedio = $suma / $totalNotas;
        
        // Redondeamos a 2 decimales para presentar mejor el resultado
        return round($promedio, 2);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $misNotas = [
            $_POST['nota1'], 
            $_POST['nota2'], 
            $_POST['nota3'], 
            $_POST['nota4']
        ];
        
        // Variable para saber si hay un error en las notas
        $notasValidas = true;
        
        // Revisamos que ninguna nota sea negativa o mayor a 10
        for ($i = 0; $i < 4; $i++) {
            if ($misNotas[$i] < 0 || $misNotas[$i] > 10) {
                $notasValidas = false;
                break;
            }
        }

        if ($notasValidas == false) {
            echo "<div class='error'><strong>Error:</strong> Las notas deben estar entre 0 y 10. Verifique los datos.</div>";
        } else {
            echo "<div class='resultado'>";
            echo "Tus notas son: " . implode(", ", $misNotas) . "<br>";
            echo "Promedio final: <strong>" . calcularPromedioNotas($misNotas) . "</strong>";
            echo "</div>";
        }
    }
    ?>
</div>
</body>
</html>