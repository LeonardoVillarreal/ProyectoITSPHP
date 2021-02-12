<?php
require_once "../modelos/Articulos.php";

$articulo = new Articulos();
$idarticulo = isset($_POST["idarticulo"])?limpiarCadenas($_POST["idarticulo"]): " ";
$idcategoria = isset($_POST["idcategoria"])?limpiarCadenas($_POST["idcategoria"]): " ";
$nombre = isset($_POST["nombre"])?limpiarCadenas($_POST["nombre"]): " ";
$codigo = isset($_POST["codigo"])?limpiarCadenas($_POST["codigo"]): " ";
$stock = isset($_POST["stock"])?limpiarCadenas($_POST["stock"]): " ";
$descripcion = isset($_POST["descripcion"])?limpiarCadenas($_POST["descripcion"]): " ";
$imagen = isset($_POST["imagen"])?limpiarCadenas($_POST["imagen"]): " ";

switch ($_GET["op"]) {
       
    case 'guardaryeditar':
        if(!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])){
            $imagen= $_POST["imagenactual"];
        }else{
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if($_FILES['imagen']['type']=="image/jpg" || $_FILES['imagen']['type']=="image/png" || $_FILES['imagen']['type']=="image/jpeg"){
                $imagen = round(microtime(true).'.'. end($ext));
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/".$imagen);
            }
        }
        if(empty($idarticulo)){
            $respuesta=$articulo->insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);            
            echo $respuesta ? "Artículo registrado" : "Artículo no registrado";
        }else{
            $respuesta=$articulo->actualizar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
            echo $respuesta ? "Artículo actualizado" : "Artículo no actualizado";
        }
        break;
    case 'desactivar':
        $respuesta=$articulo->desactivar($idarticulo);
        echo $respuesta ? "Artículo desactivado" : "Artículo no se pudo desactivar";
        break;
    case 'activar':
        $respuesta=$articulo->activar($idarticulo);
        echo $respuesta ? "Artículo activado" : "Artículo no se pudo activar";
        break;
    case 'mostrar':
        $respuesta=$articulo->mostrar($idarticulo);
        //Codificar con json
        echo json_encode($respuesta);
        break;
    case 'listar':
        $respuesta=$articulo->listar();
        
        $data = array();
        while($reg = $respuesta->fetch_object()){
            $data[]=array(
                "0"=>$reg->condicion ?'<button class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.
                     '  <button class="btn btn-danger" onclick="desactivar('.$reg->idarticulo.')"><i class="fa fa-close"></i></button>':
                     '<button class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.
                     '  <button class="btn btn-primary" onclick="activar('.$reg->idarticulo.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->categoria,
                "3"=>$reg->codigo,
                "4"=>$reg->stock,
                "5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>",
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
        
    case 'selectcategoria':
        require_once "../modelos/Categorias.php";
        $categoria = new Categorias();
        $respuesta = $categoria->select();
        
        while($reg=$respuesta->fetch_object()){
            echo '<option value='.$reg->idcategoria.'>'.$reg->nombre.'</option>';
        }
        break;
}
?>

