<?php
class ErrorController extends Controller {
    function __construct() {
        parent::__construct();
        // Definimos la propiedad mensaje con $this->
        $this->view->mensaje = "Error al cargar el recurso";
        $this->view->renderView('error/error.php');
    }
}