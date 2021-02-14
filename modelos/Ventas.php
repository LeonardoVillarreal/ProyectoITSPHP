<?php
//Incluir la conexion en la base de datos
require "../config/Conexion.php";

Class Ventas{
    //Implementar un constructor
    public function __construct() {
        
    }
        
    //Implementar un método para insertar registros
    public function insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta){
        $sql = "INSERT INTO venta (idcliente,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_venta,condicion) VALUES('$idcliente','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_venta','1')";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para actualizar registros
    public function actualizar($id,$idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta){
        $sql = "UPDATE venta SET idcliente='$idcliente',idusuario='$idusuario',tipo_comprobante='$tipo_comprobante',serie_comprobante='$serie_comprobante',num_comprobante='$num_comprobante',fecha_hora='$fecha_hora',impuesto='$impuesto',total_venta='$total_venta'"
                . "WHERE idventa='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para mostrar un registro
    public function mostrar($id){
        $sql = "SELECT * FROM venta WHERE idventa='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    //Método para desactivar una venta
    public function desactivar($id){
        $sql = "UPDATE venta SET condicion='0' WHERE idventa='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Método para activar una venta
    public function activar($id){
        $sql = "UPDATE venta SET condicion='1' WHERE idventa='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para listar todos los registros
    public function listar(){
        $sql = "SELECT v.idventa,v.num_comprobante,v.serie_comprobante,v.tipo_comprobante,v.idcliente,p.nombre AS nombrec,v.idusuario,u.nombre AS nombreu,v.fecha_hora,v.impuesto,v.total_venta,v.condicion FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario";
        return ejecutarConsulta($sql);
    }
    
    public function select(){
        $sql = "SELECT * FROM venta WHERE condicion = 1";
        return ejecutarConsulta($sql);
    }
}
?>
