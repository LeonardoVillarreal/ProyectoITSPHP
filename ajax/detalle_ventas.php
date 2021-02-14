<?php
require_once "../modelos/Detalle_Ventas.php";

$detalle_venta = new Detalle_Ventas();
$iddetalle_venta = isset($_POST["iddetalle_venta"])?limpiarCadenas($_POST["iddetalle_venta"]): " ";
$idventa = isset($_POST["idventa"])?limpiarCadenas($_POST["idventa"]): " ";
$idarticulo = isset($_POST["idarticulo"])?limpiarCadenas($_POST["idarticulo"]): " ";
$cantidad = isset($_POST["cantidad"])?limpiarCadenas($_POST["cantidad"]): " ";
$precio_venta = isset($_POST["precio_venta"])?limpiarCadenas($_POST["precio_venta"]): " ";
$descuento = isset($_POST["descuento"])?limpiarCadenas($_POST["descuento"]): " ";


switch ($_GET["op"]) {
       
    case 'guardaryeditar':
        if(empty($iddetalle_venta)){
            $respuesta=$detalle_venta->insertar($idventa,$idarticulo,$cantidad,$precio_venta,$descuento);            
            echo $respuesta ? "Detalle de venta registrado" : "Detalle de venta no registrado";
        }else{
            $respuesta=$detalle_venta->actualizar($iddetalle_venta,$idventa,$idarticulo,$cantidad,$precio_venta,$descuento);
            echo $respuesta ? "Detalle de venta actualizado" : "Detalle de venta no actualizado";
        }
        break;
    case 'desactivar':
        $respuesta=$detalle_venta->desactivar($iddetalle_venta);
        echo $respuesta ? "Detalle de venta desactivado" : "Detalle de venta no se pudo desactivar";
        break;
    case 'activar':
        $respuesta=$detalle_venta->activar($iddetalle_venta);
        echo $respuesta ? "Detalle de venta activado" : "Detalle de venta no se pudo activar";
        break;
    case 'mostrar':
        $respuesta=$detalle_venta->mostrar($iddetalle_venta);
        //Codificar con json
        echo json_encode($respuesta);
        break;
    case 'listar':
        $respuesta=$detalle_venta->listar();
        
        $data = array();
        while($reg = $respuesta->fetch_object()){
            $data[]=array(
                "0"=>$reg->condicion ?'<button class="btn btn-warning" onclick="mostrar('.$reg->iddetalle_venta.')"><i class="fa fa-pencil"></i></button>'.
                     '  <button class="btn btn-danger" onclick="desactivar('.$reg->iddetalle_venta.')"><i class="fa fa-close"></i></button>':
                     '<button class="btn btn-warning" onclick="mostrar('.$reg->iddetalle_venta.')"><i class="fa fa-pencil"></i></button>'.
                     '  <button class="btn btn-primary" onclick="activar('.$reg->iddetalle_venta.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->comprobante,
                "2"=>$reg->nombre,
                "3"=>$reg->cantidad,
                "4"=>$reg->precio_venta,
                "5"=>$reg->descuento,
                "6"=>$reg->condicion ? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
                    );
        }
        
        $results=array(
            "sEcho"=>1,//Información para datatable
            "iTotalRecords"=> count($data),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=> count($data),//enviamos el total de registros a visualizar
            "aaData"=>$data);
        
        echo json_encode($results);
        break;
        
    case 'selectventa':
        require_once "../modelos/Ventas.php";
        $venta = new Ventas();
        $respuesta = $venta->select();
        
        while($reg=$respuesta->fetch_object()){
            echo '<option value='.$reg->idventa.'>'.$reg->num_comprobante.'</option>';
        }
        break;
        
    case 'selectarticulo':
        require_once "../modelos/Articulos.php";
        $articulo = new Articulos();
        $respuesta = $articulo->select();
        
        while($reg=$respuesta->fetch_object()){
            echo '<option value='.$reg->idarticulo.'>'.$reg->nombre.'</option>';
        }
        break;
}
?>

