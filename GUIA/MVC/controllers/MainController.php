<?php

class MainController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function principal() { 
        $this->view->listaPersonas = $this->model->listaPersonas();
        $this->view->listaOcupaciones = $this->model->listaOcupaciones(); 
        $this->view->persona = $this->model->obtenerPersona();
        $this->view->listaOcupaciones2 = $this->model->listaOcupaciones(); 
        $this->view->renderView('main/main.php'); 
    } 

    public function agregarPersona() { 
       $this->model->agregarPersona($_POST["nombre"], $_POST["edad"], $_POST["telefono"], $_POST["sexo"], $_POST["ocupacion"], $_POST["fecha"]); 
       
       // mensaje de éxito para cuando funcione el Insert
       $_SESSION['mensaje'] = "¡Genial! La nueva persona fue registrada con éxito en el sistema.";
       header('Location: ' . constant('URL') . "Main/principal"); 
    } 

    public function modificarPersona() {
        $this->model->modificarPersona($_POST["id"], $_POST["nombre"], $_POST["edad"], $_POST["telefono"], $_POST["sexo"], $_POST["ocupacion"], $_POST["fecha"]); 
        
        // mensaje de éxito para el Update
        $_SESSION['mensaje'] = "¡Excelente! Los datos de la persona han sido actualizados correctamente.";
        header('Location: ' . constant('URL') . "Main/principal"); 
    }

    public function eliminarPersona($id) { 
        $this->model->eliminarPersona($id);
        
        // Mensaje de éxito para el Delete
        $_SESSION['mensaje'] = "¡Hecho! El registro fue eliminado de la base de datos de forma segura.";
        header('Location: ' . constant('URL') . "Main/principal"); 
    } 
}
?>