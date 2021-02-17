<?php
//Incluir la conexion en la base de datos
require "../config/Conexion.php";

Class Ingresos{
    //Implementar un constructor
    public function __construct() {
        
    }
        
    //Implementar un método para insertar registros
    public function insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra){
        $sql = "INSERT INTO ingreso (idproveedor,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_compra,condicion) VALUES('$idproveedor','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_compra','1')";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para actualizar registros
    public function actualizar($id,$idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra){
        $sql = "UPDATE ingreso SET idproveedor='$idproveedor',idusuario='$idusuario',tipo_comprobante='$tipo_comprobante',serie_comprobante='$serie_comprobante',num_comprobante='$num_comprobante',fecha_hora='$fecha_hora',impuesto='$impuesto',total_compra='$total_compra' WHERE idingreso='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para mostrar un registro
    public function mostrar($id){
        $sql = "SELECT * FROM ingreso WHERE idingreso='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    //Método para desactivar una ingreso
    public function desactivar($id){
        $sql = "UPDATE ingreso SET condicion='0' WHERE idingreso='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Método para activar una ingreso
    public function activar($id){
        $sql = "UPDATE ingreso SET condicion='1' WHERE idingreso='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para listar todos los registros
    public function listar(){
        $sql = "SELECT i.idingreso,i.num_comprobante,i.serie_comprobante,i.tipo_comprobante,i.idproveedor,p.nombre AS nombrep,i.idusuario,u.nombre AS nombreu,i.fecha_hora,i.impuesto,i.total_compra,i.condicion FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario";
        return ejecutarConsulta($sql);
    }
    
    public function select(){
        $sql = "SELECT * FROM ingreso WHERE condicion = 1";
        return ejecutarConsulta($sql);
    }
}
?>
