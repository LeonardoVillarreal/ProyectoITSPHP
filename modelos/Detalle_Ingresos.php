<?php
//Incluir la conexion en la base de datos
require "../config/Conexion.php";

Class Detalle_Ingresos{
    //Implementar un constructor
    public function __construct() {
        
    }
        
    //Implementar un método para insertar registros
    public function insertar($idingreso,$idarticulo,$cantidad,$precio_compra,$precio_venta){
        $sql = "INSERT INTO detalle_ingreso (idingreso,idarticulo,cantidad,precio_compra,precio_venta,condicion) VALUES('$idingreso','$idarticulo','$cantidad','$precio_compra','$precio_venta','1')";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para actualizar registros
    public function actualizar($id,$idingreso,$idarticulo,$cantidad,$precio_compra,$precio_venta){
        $sql = "UPDATE detalle_ingreso SET idingreso='$idingreso',idarticulo='$idarticulo',cantidad='$cantidad',precio_compra='$precio_compra',precio_venta='$precio_venta'"
                . "WHERE iddetalle_ingreso='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para mostrar un registro
    public function mostrar($id){
        $sql = "SELECT * FROM detalle_ingreso WHERE iddetalle_ingreso='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    //Método para desactivar una detalle_ingreso
    public function desactivar($id){
        $sql = "UPDATE detalle_ingreso SET condicion='0' WHERE iddetalle_ingreso='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Método para activar una detalle_ingreso
    public function activar($id){
        $sql = "UPDATE detalle_ingreso SET condicion='1' WHERE iddetalle_ingreso='$id'";
        return ejecutarConsulta($sql);
    }
    
    //Implementar un método para listar todos los registros
    public function listar(){
        $sql = "SELECT d.iddetalle_ingreso, d.idingreso,i.num_comprobante AS comprobante,d.idarticulo, a.nombre AS nombre,  d.cantidad,d.precio_compra,d.precio_venta,d.condicion FROM detalle_ingreso d INNER JOIN ingreso i ON d.idingreso=i.idingreso INNER JOIN articulo a ON d.idarticulo=a.idarticulo";
        return ejecutarConsulta($sql);
    }
    
    public function select(){
        $sql = "SELECT * FROM detalle_ingreso WHERE condicion = 1";
        return ejecutarConsulta($sql);
    }
}
?>
