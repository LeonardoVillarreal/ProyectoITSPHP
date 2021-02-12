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
    case 'listar':
        $respuesta=$persona->listar();
        
        $data = array();
        while($reg = $respuesta->fetch_object()){
            $data[]=array(
                "0"=>$reg->condicion ?'<button class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
                     '  <button class="btn btn-danger" onclick="desactivar('.$reg->idpersona.')"><i class="fa fa-close"></i></button>':
                     '<button class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
                     '  <button class="btn btn-primary" onclick="activar('.$reg->idpersona.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->tipo_persona,
                "2"=>$reg->nombre,
                "3"=>$reg->tipo_documento,
                "4"=>$reg->num_documento,
                "5"=>$reg->direccion,
                "6"=>$reg->telefono,
                "7"=>$reg->email,
                "8"=>$reg->condicion ?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
                    );
        }
        
        $results=array(
            "sEcho"=>1,//Información para datatable
            "iTotalRecords"=> count($data),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=> count($data),//enviamos el total de registros a visualizar
            "aaData"=>$data);
        
        echo json_encode($results);
        break;
}
?>
