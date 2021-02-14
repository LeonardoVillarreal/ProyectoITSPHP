<?php
require_once "../modelos/Ingresos.php";

$ingreso = new Ingresos();
$idingreso = isset($_POST["idingreso"])?limpiarCadenas($_POST["idingreso"]): " ";
$idproveedor = isset($_POST["idproveedor"])?limpiarCadenas($_POST["idproveedor"]): " ";
$idusuario = isset($_POST["idusuario"])?limpiarCadenas($_POST["idusuario"]): " ";
$tipo_comprobante = isset($_POST["tipo_comprobante"])?limpiarCadenas($_POST["tipo_comprobante"]): " ";
$serie_comprobante = isset($_POST["serie_comprobante"])?limpiarCadenas($_POST["serie_comprobante"]): " ";
$num_comprobante = isset($_POST["num_comprobante"])?limpiarCadenas($_POST["num_comprobante"]): " ";
$fecha_hora = isset($_POST["fecha_hora"])?limpiarCadenas($_POST["fecha_hora"]): " ";
$impuesto = isset($_POST["impuesto"])?limpiarCadenas($_POST["impuesto"]): " ";
$total_compra = isset($_POST["total_compra"])?limpiarCadenas($_POST["total_compra"]): " ";

switch ($_GET["op"]) {
       
    case 'guardaryeditar':
        if(empty($idingreso)){
            $respuesta=$ingreso->insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra);            
            echo $respuesta ? "Ingreso registrado" : "Ingreso no registrado";
        }else{
            $respuesta=$ingreso->actualizar($idingreso,$idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra);
            echo $respuesta ? "Ingreso actualizado" : "Ingreso no actualizado";
        }
        break;
    case 'desactivar':
        $respuesta=$ingreso->desactivar($idingreso);
        echo $respuesta ? "Ingreso desactivado" : "Ingreso no se pudo desactivar";
        break;
    case 'activar':
        $respuesta=$ingreso->activar($idingreso);
        echo $respuesta ? "Ingreso activado" : "Ingreso no se pudo activar";
        break;
    case 'mostrar':
        $respuesta=$ingreso->mostrar($idingreso);
        //Codificar con json
        echo json_encode($respuesta);
        break;
    case 'listar':
        $respuesta=$ingreso->listar();
        
        $data = array();
        while($reg = $respuesta->fetch_object()){
            $data[]=array(
                "0"=>$reg->condicion ?'<button class="btn btn-warning" onclick="mostrar('.$reg->idingreso.')"><i class="fa fa-pencil"></i></button>'.
                     '  <button class="btn btn-danger" onclick="desactivar('.$reg->idingreso.')"><i class="fa fa-close"></i></button>':
                     '<button class="btn btn-warning" onclick="mostrar('.$reg->idingreso.')"><i class="fa fa-pencil"></i></button>'.
                     '  <button class="btn btn-primary" onclick="activar('.$reg->idingreso.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->num_comprobante,
                "2"=>$reg->serie_comprobante,
                "3"=>$reg->tipo_comprobante,
                "4"=>$reg->nombrep,
                "5"=>$reg->nombreu,
                "6"=>$reg->fecha_hora,
                "7"=>$reg->impuesto,
                "8"=>$reg->total_compra,
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
        
    case 'selectproveedor':
        require_once "../modelos/Personas.php";
        $proveedor = new Personas();
        $respuesta = $proveedor->selectProveedor();
        
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

