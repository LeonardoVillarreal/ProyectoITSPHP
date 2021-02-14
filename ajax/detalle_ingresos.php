<?php
require_once "../modelos/Detalle_Ingresos.php";

$detalle_ingreso = new Detalle_Ingresos();
$iddetalle_ingreso = isset($_POST["iddetalle_ingreso"])?limpiarCadenas($_POST["iddetalle_ingreso"]): " ";
$idingreso = isset($_POST["idingreso"])?limpiarCadenas($_POST["idingreso"]): " ";
$idarticulo = isset($_POST["idarticulo"])?limpiarCadenas($_POST["idarticulo"]): " ";
$cantidad = isset($_POST["cantidad"])?limpiarCadenas($_POST["cantidad"]): " ";
$precio_compra = isset($_POST["precio_compra"])?limpiarCadenas($_POST["precio_compra"]): " ";
$precio_venta = isset($_POST["precio_venta"])?limpiarCadenas($_POST["precio_venta"]): " ";


switch ($_GET["op"]) {
       
    case 'guardaryeditar':
        if(empty($iddetalle_ingreso)){
            $respuesta=$detalle_ingreso->insertar($idingreso,$idarticulo,$cantidad,$precio_compra,$precio_venta);            
            echo $respuesta ? "Detalle de ingreso registrado" : "Detalle de ingreso no registrado";
        }else{
            $respuesta=$detalle_ingreso->actualizar($iddetalle_ingreso,$idingreso,$idarticulo,$cantidad,$precio_compra,$precio_venta);
            echo $respuesta ? "Detalle de ingreso actualizado" : "Detalle de ingreso no actualizado";
        }
        break;
    case 'desactivar':
        $respuesta=$detalle_ingreso->desactivar($iddetalle_ingreso);
        echo $respuesta ? "Detalle de ingreso desactivado" : "Detalle de ingreso no se pudo desactivar";
        break;
    case 'activar':
        $respuesta=$detalle_ingreso->activar($iddetalle_ingreso);
        echo $respuesta ? "Detalle de ingreso activado" : "Detalle de ingreso no se pudo activar";
        break;
    case 'mostrar':
        $respuesta=$detalle_ingreso->mostrar($iddetalle_ingreso);
        //Codificar con json
        echo json_encode($respuesta);
        break;
    case 'listar':
        $respuesta=$detalle_ingreso->listar();
        
        $data = array();
        while($reg = $respuesta->fetch_object()){
            $data[]=array(
                "0"=>$reg->condicion ?'<button class="btn btn-warning" onclick="mostrar('.$reg->iddetalle_ingreso.')"><i class="fa fa-pencil"></i></button>'.
                     '  <button class="btn btn-danger" onclick="desactivar('.$reg->iddetalle_ingreso.')"><i class="fa fa-close"></i></button>':
                     '<button class="btn btn-warning" onclick="mostrar('.$reg->iddetalle_ingreso.')"><i class="fa fa-pencil"></i></button>'.
                     '  <button class="btn btn-primary" onclick="activar('.$reg->iddetalle_ingreso.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->comprobante,
                "2"=>$reg->nombre,
                "3"=>$reg->cantidad,
                "4"=>$reg->precio_compra,
                "5"=>$reg->precio_venta,
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
        
    case 'selectingreso':
        require_once "../modelos/Ingresos.php";
        $ingreso = new Ingresos();
        $respuesta = $ingreso->select();
        
        while($reg=$respuesta->fetch_object()){
            echo '<option value='.$reg->idingreso.'>'.$reg->num_comprobante.'</option>';
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

