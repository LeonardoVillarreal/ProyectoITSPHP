<?php
require_once "../modelos/Personas.php";

$persona = new Personas();
$idpersona = isset($_POST["idpersona"])?limpiarCadenas($_POST["idpersona"]): " ";
$tipo_persona = isset($_POST["tipo_persona"])?limpiarCadenas($_POST["tipo_persona"]): " ";
$nombre = isset($_POST["nombre"])?limpiarCadenas($_POST["nombre"]): " ";
$tipo_documento = isset($_POST["tipo_documento"])?limpiarCadenas($_POST["tipo_documento"]): " ";
$num_documento = isset($_POST["num_documento"])?limpiarCadenas($_POST["num_documento"]): " ";
$direccion = isset($_POST["direccion"])?limpiarCadenas($_POST["direccion"]): " ";
$telefono = isset($_POST["telefono"])?limpiarCadenas($_POST["telefono"]): " ";
$email = isset($_POST["email"])?limpiarCadenas($_POST["email"]): " ";

switch ($_GET["op"]) {
    
    case 'guardaryeditar':
        if(empty($idpersona)){
            $respuesta=$persona->insertar($tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email);            
            echo $respuesta ? "Persona registrada" : "Persona no registrada";
        }else{
            $respuesta=$persona->actualizar($idpersona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email);
            echo $respuesta ? "Persona actualizada" : "Persona no actualizada";
        }
        break;
        
    case 'eliminar':
        $rspta=$persona->eliminar($idpersona);
        echo $rspta ? "Persona eliminada" : "Persona no se puede eliminar";
	break;
    case 'desactivar':
        $respuesta=$persona->desactivar($idpersona);
        echo $respuesta ? "Persona desactivada" : "Persona no se pudo desactivar";
        break;
    case 'activar':
        $respuesta=$persona->activar($idpersona);
        echo $respuesta ? "Persona activada" : "Persona no se pudo activar";
        break;
    case 'mostrar':
        $respuesta=$persona->mostrar($idpersona);
        //Codificar con json
        echo json_encode($respuesta);
        break;
    case 'listarp':
		$rspta=$persona->selectProveedor();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->idpersona.')"><i class="fa fa-trash"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->tipo_documento,
 				"3"=>$reg->num_documento,
 				"4"=>$reg->telefono,
 				"5"=>$reg->email
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
        
        case 'listarc':
		$rspta=$persona->selectCliente();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->idpersona.')"><i class="fa fa-trash"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->tipo_documento,
 				"3"=>$reg->num_documento,
 				"4"=>$reg->telefono,
 				"5"=>$reg->email
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
}
?>
