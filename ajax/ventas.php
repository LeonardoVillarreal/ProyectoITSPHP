<?php
require_once "../modelos/Ventas.php";

$venta = new Ventas();
$idventa = isset($_POST["idventa"])?limpiarCadenas($_POST["idventa"]): " ";
$idcliente = isset($_POST["idcliente"])?limpiarCadenas($_POST["idcliente"]): " ";
$idusuario = isset($_POST["idusuario"])?limpiarCadenas($_POST["idusuario"]): " ";
$tipo_comprobante = isset($_POST["tipo_comprobante"])?limpiarCadenas($_POST["tipo_comprobante"]): " ";
$serie_comprobante = isset($_POST["serie_comprobante"])?limpiarCadenas($_POST["serie_comprobante"]): " ";
$num_comprobante = isset($_POST["num_comprobante"])?limpiarCadenas($_POST["num_comprobante"]): " ";
$fecha_hora = isset($_POST["fecha_hora"])?limpiarCadenas($_POST["fecha_hora"]): " ";
$impuesto = isset($_POST["impuesto"])?limpiarCadenas($_POST["impuesto"]): " ";
$total_venta = isset($_POST["total_venta"])?limpiarCadenas($_POST["total_venta"]): " ";

switch ($_GET["op"]) {
       
    case 'guardaryeditar':
        if(empty($idventa)){
            $respuesta=$venta->insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta);            
            echo $respuesta ? "Venta registrada" : "Venta no registrada";
        }else{
            $respuesta=$venta->actualizar($idventa,$idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta);
            echo $respuesta ? "Venta actualizada" : "Venta no actualizada";
        }
        break;
    case 'desactivar':
        $respuesta=$venta->desactivar($idventa);
        echo $respuesta ? "Venta desactivada" : "Venta no se pudo desactivar";
        break;
    case 'activar':
        $respuesta=$venta->activar($idventa);
        echo $respuesta ? "Venta activada" : "Venta no se pudo activar";
        break;
    case 'mostrar':
        $respuesta=$venta->mostrar($idventa);
        //Codificar con json
        echo json_encode($respuesta);
        break;
    case 'listar':
        $respuesta=$venta->listar();
        
        $data = array();
        while($reg = $respuesta->fetch_object()){
            $data[]=array(
                "0"=>$reg->condicion ?'<button class="btn btn-warning" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-pencil"></i></button>'.
                     '  <button class="btn btn-danger" onclick="desactivar('.$reg->idventa.')"><i class="fa fa-close"></i></button>':
                     '<button class="btn btn-warning" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-pencil"></i></button>'.
                     '  <button class="btn btn-primary" onclick="activar('.$reg->idventa.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->num_comprobante,
                "2"=>$reg->serie_comprobante,
                "3"=>$reg->tipo_comprobante,
                "4"=>$reg->nombrec,
                "5"=>$reg->nombreu,
                "6"=>$reg->fecha_hora,
                "7"=>$reg->impuesto,
                "8"=>$reg->total_venta,
                "9"=>$reg->condicion ? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
                    );
        }
        
        $results=array(
            "sEcho"=>1,//Información para datatable
            "iTotalRecords"=> count($data),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=> count($data),//enviamos el total de registros a visualizar
            "aaData"=>$data);
        
        echo json_encode($results);
        break;
        
    case 'selectcliente':
        require_once "../modelos/Personas.php";
        $cliente = new Personas();
        $respuesta = $cliente->selectCliente();
        
        while($reg=$respuesta->fetch_object()){
            echo '<option value='.$reg->idpersona.'>'.$reg->nombre.'</option>';
        }
        break;
        
    case 'selectusuario':
        require_once "../modelos/Usuarios.php";
        $usuario = new Usuarios();
        $respuesta = $usuario->select();
        
        while($reg=$respuesta->fetch_object()){
            echo '<option value='.$reg->idusuario.'>'.$reg->nombre.'</option>';
        }
        break;
}
?>

