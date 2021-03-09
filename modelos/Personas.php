<?php
//Incluir la conexion en la base de datos
require "../config/Conexion.php";

Class Personas{
    //Implementar un constructor
    public function __construct() {
        
    }
        
    //Implementar un método para insertar registros
    public function insertar($tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email){
        $sql = "INSERT INTO persona (tipo_persona,nombre,tipo_documento,num_documento,direccion,telefono,email,condicion) VALUES('$tipo_persona', '$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email','1')";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para actualizar registros
    public function actualizar($id,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email){
        $sql = "UPDATE persona SET tipo_persona='$tipo_persona',nombre='$nombre',tipo_documento='$tipo_documento',num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email'"
                . "WHERE idpersona='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para mostrar un registro
    public function mostrar($id){
        $sql = "SELECT * FROM persona WHERE idpersona='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    //Método para desactivar una persona
    public function desactivar($id){
        $sql = "UPDATE persona SET condicion='0' WHERE idpersona='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Método para activar una persona
    public function activar($id){
        $sql = "UPDATE persona SET condicion='1' WHERE idpersona='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para listar todos los registros
    public function listar(){
        $sql = "SELECT * FROM persona";
        return ejecutarConsulta($sql);
    }
    
    public function selectProveedor(){
        $sql = "SELECT * FROM persona WHERE tipo_persona LIKE 'Proveedor' AND condicion = 1";
        return ejecutarConsulta($sql);
    }
    
    public function selectCliente(){
        $sql = "SELECT * FROM persona WHERE tipo_persona LIKE 'Cliente' AND condicion = 1";
        return ejecutarConsulta($sql);
    }
    
    public function eliminar($idpersona)
    {
        $sql="DELETE FROM persona WHERE idpersona='$idpersona'";
        return ejecutarConsulta($sql);
    }
}
?>
