<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Caso 4 - Contar Vocales</title>
    <style>
        body { background-color: #121212; color: #e0e0e0; font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #1e1e1e; padding: 20px; border-radius: 8px; border-top: 4px solid #3f51b5; }
        h2 { color: #7986cb; }
        .resultado { background-color: #2c2c2c; padding: 15px; border-left: 4px solid #3f51b5; margin-top: 15px; }
        .error { background-color: #3b1c1c; padding: 15px; border-left: 4px solid #ef5350; margin-top: 15px; color: #ef5350; }
        input[type="text"] { width: 100%; padding: 8px; margin-bottom: 10px; background: #333; color: white; border: 1px solid #555; }
        input[type="submit"] { background-color: #3f51b5; color: white; padding: 10px 15px; border: none; cursor: pointer; }
    </style>
</head>
<body>
<div class="container">
    <h2>Caso 4: Contar las Vocales</h2>
    
    <form method="POST">
        <label>Escriba un texto:</label>
        <input type="text" name="texto_usuario" required>
        <input type="submit" value="Analizar Texto">
    </form>

    <?php
    function contarVocales($texto) {
        // Pasamos todo a minusculas para no tener que validar mayusculas
        $texto = strtolower($texto);
        $contador = 0;
        
        // Guardamos el tamaño del texto para saber hasta donde llega el ciclo
        $longitud = strlen($texto);

        // Revisando letra por letra
        for ($i = 0; $i < $longitud; $i++) {
            $letra = $texto[$i];
            
            // Compruebo si la letra en la que estamos es alguna de las 5 vocales
            if ($letra == 'a' || $letra == 'e' || $letra == 'i' || $letra == 'o' || $letra == 'u') {
                $contador = $contador + 1; // Si una vocal, la cuenta 
            }
        }

        return $contador;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Usamos trim para quitar los espacios vacios
        $miTexto = trim($_POST['texto_usuario']);
        
        // Validamos que no sea un texto vacio ni puros numeros
        if ($miTexto == "" || is_numeric($miTexto)) {
            echo "<div class='error'><strong>Error:</strong> Por favor ingrese un texto válido, no solo números.</div>";
        } else {
            echo "<div class='resultado'>";
            echo "Texto ingresado: '$miTexto' <br>";
            echo "Vocales encontradas: <strong>" . contarVocales($miTexto) . "</strong>";
            echo "</div>";
        }
    }
    ?>
</div>
</body>
</html>