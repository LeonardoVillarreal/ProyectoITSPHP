<?php
require_once "../modelos/Categorias.php";

$categoria = new Categorias();
$idcategoria = isset($_POST["idcategoria"])?limpiarCadenas($_POST["idcategoria"]): " ";
$nombre = isset($_POST["nombre"])?limpiarCadenas($_POST["nombre"]): " ";
$descripcion = isset($_POST["descripcion"])?limpiarCadenas($_POST["descripcion"]): " ";

switch ($_GET["op"]) {
    
    case 'guardaryeditar':
        if(empty($idcategoria)){
            $respuesta=$categoria->insertar($nombre, $descripcion);            
            echo $respuesta ? "Categoría registrada" : "Categoría no registrada";
        }else{
            $respuesta=$categoria->actualizar($idcategoria, $nombre, $descripcion);
            echo $respuesta ? "Categoría actualizada" : "Categoría no actualizada";
        }
        break;
    case 'desactivar':
        $respuesta=$categoria->desactivar($idcategoria);
        echo $respuesta ? "Categoría desactivada" : "Categoría no se pudo desactivar";
        break;
    case 'activar':
        $respuesta=$categoria->activar($idcategoria);
        echo $respuesta ? "Categoría activada" : "Categoría no se pudo activar";
        break;
    case 'mostrar':
        $respuesta=$categoria->mostrar($idcategoria);
        //Codificar con json
        echo json_encode($respuesta);
        break;
    case 'listar':
        $respuesta=$categoria->listar();
        
        $data = array();
        while($reg = $respuesta->fetch_object()){
            $data[]=array(
                "0"=>$reg->condicion ?'<button class="btn btn-warning" onclick="mostrar('.$reg->idcategoria.')"><i class="fa fa-pencil"></i></button>'.
                     '  <button class="btn btn-danger" onclick="desactivar('.$reg->idcategoria.')"><i class="fa fa-close"></i></button>':
                     '<button class="btn btn-warning" onclick="mostrar('.$reg->idcategoria.')"><i class="fa fa-pencil"></i></button>'.
                     '  <button class="btn btn-primary" onclick="activar('.$reg->idcategoria.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->descripcion,
                "3"=>$reg->condicion ?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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
