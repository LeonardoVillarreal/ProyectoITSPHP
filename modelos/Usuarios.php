<?php
//Incluir la conexion en la base de datos
require "../config/Conexion.php";

Class Usuarios{
    //Implementar un constructor
    public function __construct() {
        
    }
        
    //Implementar un método para insertar registros
    public function insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave){
        $sql = "INSERT INTO usuario (nombre,tipo_documento,num_documento,direccion,telefono,email,cargo,login,clave,condicion) "
                . "VALUES('$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email','$cargo','$login','$clave','1')";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para actualizar registros
    public function actualizar($id,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave){
        $sql = "UPDATE usuario SET nombre='$nombre',tipo_documento='$tipo_documento',num_documento='$num_documento',"
                . "direccion='$direccion',telefono='$telefono',email='$email', cargo='$cargo',login='$login',clave='$clave'"
                . "WHERE idusuario='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para mostrar un registro
    public function mostrar($id){
        $sql = "SELECT * FROM usuario WHERE idusuario='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    //Método para desactivar una usuario
    public function desactivar($id){
        $sql = "UPDATE usuario SET condicion='0' WHERE idusuario='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Método para activar una usuario
    public function activar($id){
        $sql = "UPDATE usuario SET condicion='1' WHERE idusuario='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para listar todos los registros
    public function listar(){
        $sql = "SELECT * FROM usuario";
        return ejecutarConsulta($sql);
    }
    
    public function select(){
        $sql = "SELECT * FROM usuario WHERE condicion = 1";
        return ejecutarConsulta($sql);
    }
}
?>

