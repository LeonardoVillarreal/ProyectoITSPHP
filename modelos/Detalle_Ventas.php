<?php
//Incluir la conexion en la base de datos
require "../config/Conexion.php";

Class Detalle_Ventas{
    //Implementar un constructor
    public function __construct() {
        
    }
        
    //Implementar un método para insertar registros
    public function insertar($idventa,$idarticulo,$cantidad,$precio_venta,$descuento){
        $sql = "INSERT INTO detalle_venta (idventa,idarticulo,cantidad,precio_venta,descuento,condicion) VALUES('$idventa','$idarticulo','$cantidad','$precio_venta','$descuento','1')";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para actualizar registros
    public function actualizar($id,$idventa,$idarticulo,$cantidad,$precio_venta,$descuento){
        $sql = "UPDATE detalle_venta SET idventa='$idventa',idarticulo='$idarticulo',cantidad='$cantidad',precio_venta='$precio_venta',descuento='$descuento'"
                . "WHERE iddetalle_venta='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para mostrar un registro
    public function mostrar($id){
        $sql = "SELECT * FROM detalle_venta WHERE iddetalle_venta='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    //Método para desactivar una detalle_venta
    public function desactivar($id){
        $sql = "UPDATE detalle_venta SET condicion='0' WHERE iddetalle_venta='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Método para activar una detalle_venta
    public function activar($id){
        $sql = "UPDATE detalle_venta SET condicion='1' WHERE iddetalle_venta='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para listar todos los registros
    public function listar(){
        $sql = "SELECT d.iddetalle_venta, d.idventa,v.num_comprobante AS comprobante,d.idarticulo, a.nombre AS nombre,  d.cantidad,d.precio_venta,d.descuento,d.condicion FROM detalle_venta d INNER JOIN venta v ON d.idventa=v.idventa INNER JOIN articulo a ON d.idarticulo=a.idarticulo";
        return ejecutarConsulta($sql);
    }
    
    public function select(){
        $sql = "SELECT * FROM detalle_venta WHERE condicion = 1";
        return ejecutarConsulta($sql);
    }
}
?>
