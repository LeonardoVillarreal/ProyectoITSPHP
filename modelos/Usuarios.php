<?php
//Incluir la conexion en la base de datos
require "../config/Conexion.php";

Class Usuarios{
    //Implementar un constructor
    public function __construct() {
        
    }
        
    //Implementar un método para insertar registros
    public function insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$permisos){
        $sql = "INSERT INTO usuario (nombre,tipo_documento,num_documento,direccion,telefono,email,cargo,login,clave,imagen,condicion) "
                . "VALUES('$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email','$cargo','$login','$clave','$imagen',1')";
        //return ejecutarConsulta($sql);
        $idusuarionew = ejecutarConsulta_retornarId($sql);
        $num_elementos=0;
        $sw = true;
        while($num_elementos< count($permisos)){
            $sql_detalle="INSERT INTO usuario_permiso(idusuario,idpermiso) VALUES('$idusuarionew','$permisos[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw=false;
            $num_elementos=$num_elementos+1;          
        }
        
        return $sw;
    }
    
    //Implementar un método para actualizar registros
    public function actualizar($id,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$permisos){
        $sql = "UPDATE usuario SET nombre='$nombre',tipo_documento='$tipo_documento',num_documento='$num_documento',"
                . "direccion='$direccion',telefono='$telefono',email='$email', cargo='$cargo',login='$login',clave='$clave',imagen='$imagen'"
                . "WHERE idusuario='$id'";
        ejecutarConsulta($sql);
        //Elimiar los permisos asignados para volverlos a asignar
        $sql_borrar="DELETE FROM usuario_permiso WHERE idusuario='$id'";
        ejecutarConsulta($sql_borrar);
        $num_elementos=0;
        $sw = true;
        while($num_elementos< count($permisos)){
            $sql_detalle="INSERT INTO usuario_permiso(idusuario,idpermiso) VALUES('$id','$permisos[$num_elementos]')";
            
            ejecutarConsulta($sql_detalle) or $sw=false;
            $num_elementos=$num_elementos+1;
        }
        
        return $sw;
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
    
    public function listarMarcados($idusuario){
        $sql="SELECT * FROM usuario_permiso WHERE idusuario = '$idusuario'";
        return ejecutarConsulta($sql);
    }
    
    //función para verificar el acceso al sistema
    public function verificar($login, $clave){
        $sql="SELECT idusuario,nombre,tipo_documento,num_documento,telefono,email,cargo,imagen,login FROM usuario "
                . "WHERE login='$login' AND clave='$clave' and condicion ='1'";
        return ejecutarConsulta($sql);
    }
    
    public function insertarSolo($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen){
        $sql = "INSERT INTO usuario (nombre,tipo_documento,num_documento,direccion,telefono,email,cargo,login,clave,imagen,condicion) "
                . "VALUES('$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email','$cargo','$login','$clave','$imagen',1')";
        return ejecutarConsulta($sql);
    }
}
?>

