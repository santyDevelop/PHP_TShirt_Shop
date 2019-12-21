<?php

    class Conexion{
	public static function connect(){
            $dbConnection = new mysqli('localhost', 'root', '', 'tienda_master');
            $dbConnection->query("SET NAMES 'utf8'");
            return $dbConnection;
	}
    }
    
?>

