<?php 
// sesión para manejar los mensajes de éxito creativos
session_start();

// cargar primero la configuración
require_once "config/config.php"; 

// cargar las librerías base
require_once "libs/conexion.php"; 
require_once "libs/controller.php"; 
require_once "libs/model.php"; 
require_once "libs/view.php"; 
require_once "libs/app.php"; 

// arrancar la aplicación
$app = new App();  
?>