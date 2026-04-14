<?php 

class Model { 

    function __construct() { 
        // Instanciamos la clase conexión para que cada vez que accedamos a 
        // este constructor invoquemos una conexión diferente
        $this->con = new Database(); 
    } 

}

?>