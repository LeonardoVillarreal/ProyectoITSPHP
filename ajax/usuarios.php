<?php
require_once "../modelos/Usuarios.php";

$usuario = new Usuarios();
$idusuario = isset($_POST["idusuario"])?limpiarCadenas($_POST["idusuario"]): " ";
$nombre = isset($_POST["nombre"])?limpiarCadenas($_POST["nombre"]): " ";
$tipo_documento = isset($_POST["tipo_documento"])?limpiarCadenas($_POST["tipo_documento"]): " ";
$num_documento = isset($_POST["num_documento"])?limpiarCadenas($_POST["num_documento"]): " ";
$direccion = isset($_POST["direccion"])?limpiarCadenas($_POST["direccion"]): " ";
$telefono = isset($_POST["telefono"])?limpiarCadenas($_POST["telefono"]): " ";
$email = isset($_POST["email"])?limpiarCadenas($_POST["email"]): " ";
$cargo = isset($_POST["cargo"])?limpiarCadenas($_POST["cargo"]): " ";
$login = isset($_POST["login"])?limpiarCadenas($_POST["login"]): " ";
$clave = isset($_POST["clave"])?limpiarCadenas($_POST["clave"]): " ";
$imagen = isset($_POST["imagen"])?limpiarCadenas($_POST["imagen"]):" ";

switch ($_GET["op"]) {
    
    case 'guardaryeditar':
        if(!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])){
            $imagen= $_POST["imagenactual"];
        }else{
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if($_FILES['imagen']['type']=="image/jpg" || $_FILES['imagen']['type']=="image/png" || $_FILES['imagen']['type']=="image/jpeg"){
                $imagen = round(microtime(true).'.'. end($ext));
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/".$imagen);
            }
        }
        if(empty($idusuario)){
            $respuesta=$usuario->insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen);            
            echo $respuesta ? "Usuario registrado" : "Usuario no registrado";
        }else{
            $respuesta=$usuario->actualizar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen);
            echo $respuesta ? "Usuario actualizado" : "Usuario no actualizado";
        }
        break;
    case 'desactivar':
        $respuesta=$usuario->desactivar($idusuario);
        echo $respuesta ? "Usuario desactivada" : "Usuario no se pudo desactivar";
        break;
    case 'activar':
        $respuesta=$usuario->activar($idusuario);
        echo $respuesta ? "Usuario activada" : "Usuario no se pudo activar";
        break;
    case 'mostrar':
        $respuesta=$usuario->mostrar($idusuario);
        //Codificar con json
        echo json_encode($respuesta);
        break;
    case 'listar':
        $respuesta=$usuario->listar();
        
        $data = array();
        while($reg = $respuesta->fetch_object()){
            $data[]=array(
                "0"=>$reg->condicion ?'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
                     '  <button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')"><i class="fa fa-close"></i></button>':
                     '<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
                     '  <button class="btn btn-primary" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->tipo_documento,
                "3"=>$reg->num_documento,
                "4"=>$reg->direccion,
                "5"=>$reg->telefono,
                "6"=>$reg->email,
                "7"=>$reg->cargo,
                "8"=>$reg->login,
                "9"=>$reg->clave,
                "10"=>"<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px'>",
                "11"=>$reg->condicion ?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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

