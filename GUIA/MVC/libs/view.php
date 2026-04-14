<?php 

class View { 
    function __construct() {} 

    function renderView($vista) {
        $archivo = 'views/' . $vista;
        if (file_exists($archivo)) {
            require $archivo; 
        } else {
            // Esto te ayudará a saber si el error es por un nombre de archivo mal escrito
            echo "Error: La vista [{$archivo}] no existe.";
        }
    } 
}