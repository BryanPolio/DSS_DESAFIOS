<?php

class Controller {

    function __construct() {
        // Inicializamos la vista para que esté disponible en todos los controladores
        $this->view = new View(); 
    } 

    function loadModel($model) {
        // Se manda a llamar para cargar el modelo; cada controller está ligado a un model
        $url = 'models/' . $model . 'Model.php'; 

        if (file_exists($url)) { 
            require_once $url; 
            
            $modelName = $model . 'Model'; 
            $this->model = new $modelName(); 
        } 
    } 
} 

?>