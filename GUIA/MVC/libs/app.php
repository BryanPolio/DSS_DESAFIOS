<?php 
require_once 'controllers/ErrorController.php'; 

class App { 
    function __construct() { 
        $url = isset($_GET["url"]) ? $_GET["url"] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        // Caso: URL vacía (Carga el MainController)
        if (empty($url[0])) { 
            $archivoController = 'controllers/MainController.php';
            require_once $archivoController; 
            $controller = new MainController(); 
            $controller->loadModel('Main'); 
            $controller->principal(); 
            return false; 
        } 
       
        // Definimos la ruta del archivo y el nombre de la clase
        $archivoController = 'controllers/' . $url[0] . 'Controller.php'; 
        $clase = $url[0] . 'Controller'; 

        if (file_exists($archivoController)) { 
            require_once $archivoController; 
            $controller = new $clase; 
            $controller->loadModel($url[0]); 

            if (isset($url[1])) { 
                // Verificamos si el método existe en el controlador
                if (method_exists($controller, $url[1])) { 
                    
                    if (isset($url[2])) { 
                        // Si trae parámetro (ej. id) lo pasamos a la función
                        $controller->{$url[1]}($url[2]); 
                    } else {
                        // Si no trae parámetro, ejecutamos la función normal
                        $controller->{$url[1]}(); 
                    }

                } else { 
                    // El método no existe
                    $controller = new ErrorController(); 
                } 
            } else { 
                // No se especificó un método después del controlador
                $controller = new ErrorController(); 
            }
        } else { 
            // El archivo del controlador no existe
            $controller = new ErrorController(); 
        } 
    } 
} 
?>