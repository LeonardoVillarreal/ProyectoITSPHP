<?php
//Incluir la conexion en la base de datos
require "../config/Conexion.php";

Class Categorias{
    //Implementar un constructor
    public function __construct() {
        ;
    }
        
    //Implementar un método para insertar registros
    public function insertar($nombre, $descripcion){
        $sql = "INSERT INTO categoria (nombre, descripcion, condicion) VALUES('$nombre', '$descripcion','1')";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para actualizar registros
    public function actualizar($id,$nombre, $descripcion){
        $sql = "UPDATE categoria SET nombre='$nombre', descripcion='$descripcion' WHERE idcategoria='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para mostrar un registro
    public function mostrar($id){
        $sql = "SELECT * FROM categoria WHERE idcategoria='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    //Método para desactivar una categoría
    public function desactivar($id){
        $sql = "UPDATE categoria SET condicion='0' WHERE idcategoria='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Método para activar una categoría
    public function activar($id){
        $sql = "UPDATE categoria SET condicion='1' WHERE idcategoria='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para listar todos los registros
    public function listar(){
        $sql = "SELECT * FROM categoria";
        return ejecutarConsulta($sql);
    }
}
?>
