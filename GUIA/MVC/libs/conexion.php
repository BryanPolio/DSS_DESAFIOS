<?php

class Database {
    private $host;
    private $username;
    private $password;
    private $bd;

    function __construct() {
        // Asignamos los valores de las constantes del archivo config.php
        $this->host = constant('HOST');
        $this->username = constant('USER');
        $this->password = constant('PASSWORD');
        $this->bd = constant('DB');
    }

    function conectar() {
        try {
            // Usaremos la librería PDO para las conexiones
            $con = new PDO("mysql:dbname=$this->bd;host=$this->host", $this->username, $this->password);
            
            // Retornamos la conexión
            return $con;
        } catch (Exception $e) {
            $error = 'Error encontrado en conexión de Base de datos :( : ' . $e->getMessage() . "\n";
            return $error;
        }
    }

    function desconectar($conexion) {
        try {
            // Forzamos el cierre de la conexión si es necesario
            $conexion->query('KILL CONNECTION_ID()');
            // Hacemos null el objeto para dar fin a la comunicación con MySQL
            $conexion = null;
        } catch (Exception $e) {
            $error = 'Error encontrado en conexión de Base de datos :( : ' . $e->getMessage() . "\n";
            return $error;
        }
    }
}

?>