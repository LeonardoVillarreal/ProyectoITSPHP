<?php
//Incluir la conexion en la base de datos
require "../config/Conexion.php";

Class Permisos{
    //Implementar un constructor
    public function __construct() {
        
    }
         
    //Implementar un método para listar todos los registros
    public function listar(){
        $sql = "SELECT * FROM permiso";
        return ejecutarConsulta($sql);
    }
    
}
?>
