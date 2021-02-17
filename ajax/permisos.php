<?php
require_once "../modelos/Permisos.php";

$permiso = new Permisos();

switch ($_GET["op"]) {

    case 'listar':
        $respuesta=$permiso->listar();
        
        $data = array();
        while($reg = $respuesta->fetch_object()){
            $data[]=array(                
                "0"=>$reg->nombre            
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
