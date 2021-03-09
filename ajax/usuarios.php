<?php
session_start();
require_once "../modelos/Usuarios.php";
require_once '../config/EncripDecript.php';

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
        
        //Encriptación con Hash 256
        
        
        $claveencriptada=hash("SHA256",$clave);
        if(empty($idusuario)){
            $respuesta=$usuario->insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$claveencriptada,$imagen,$_POST['permiso']);            
            echo $respuesta ? "Usuario registrado" : "Usuario no registrado";
        }else{
            if($respuesta=$usuario->actualizar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$claveencriptada,$imagen,$_POST['permiso'])){
                echo "Se reiniciará su sesión para que los cambios tomen efecto, está seguro?";
                session_unset();
                session_destroy();
                //header('Location: ../index.php');
            }else{
                 echo $respuesta ? "Usuario actualizado" : "Usuario no actualizado";
            }                     
        }
        break;
        
        case 'guardar':
        if(!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])){
            $imagen= $_POST["imagenactual"];
        }else{
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if($_FILES['imagen']['type']=="image/jpg" || $_FILES['imagen']['type']=="image/png" || $_FILES['imagen']['type']=="image/jpeg"){
                $imagen = round(microtime(true).'.'. end($ext));
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/".$imagen);
            }
        }      
        //Encriptación con Hash 256
    
        $claveencriptada=hash("SHA256",$clave);     
        $respuesta=$usuario->insertarSolo($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$claveencriptada,$imagen);            
        echo $respuesta ? "Usuario registrado" : "Usuario no registrado";
        header('Location: ../index.php');
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
                "4"=>$reg->telefono,
                "5"=>$reg->email,
                "6"=>$reg->login,
                "7"=>"<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px'>",
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
        
    case 'permisos':
        //Obtener todos los permisos de la base
        require_once "../modelos/Permisos.php";
        $permiso = new Permisos();              
        $respuesta=$permiso->listar();
        
        //Obtener los permisos asignados
        $id=$_GET['id'];
        $marcados=$usuario->listarMarcados($id);
        $valores=array();
        //Almacenar los permisos asignados al usuario
        while($per=$marcados->fetch_object()){
            array_push($valores,$per->idpermiso);
        }
        //Mostrar los permisos en la vista
        while($reg=$respuesta->fetch_object()){
            $sw= in_array($reg->idpermiso,$valores)?'checked':'';
            echo '<li><input type="checkbox" '.$sw.' name="permiso[]" value="'.$reg->idpermiso.'">'.$reg->nombre.'</li>';
        }
        break;
        
    case 'verificar':
        $logina= $_POST['logina'];
        $clavea=$_POST['clavea'];
        
        
        $claveencriptada=hash("SHA256",$clave);
        $respuesta=$usuario->verificar($logina, $claveencriptada);
        
        $fetch=$respuesta->fetch_object();
        if(isset($fetch)){
            //Declaramos variables de sesión
            $_SESSION['idusuario']=$fetch->idusuario;
            $_SESSION['nombre']=$fetch->nombre;
            $_SESSION['imagen']=$fetch->imagen;
            $_SESSION['login']=$fetch->login;
            
            //Obtener el array de permisos marcados
            $marcados=$usuario->listarMarcados($fetch->idusuario);
            
            //Declaramos el array para guardar los permisos
            $valores= array();
            
            //Almacenar los permisos marcados en el array
            while($per=$marcados->fetch_object()){
                array_push($valores,$per->idpermiso);
            }
            
            //Determinar los accesos del usuario
            in_array(1, $valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
            in_array(2, $valores)?$_SESSION['almacen']=1:$_SESSION['almacen']=0;
            in_array(3, $valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
            in_array(4, $valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;
            in_array(5, $valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
            in_array(6, $valores)?$_SESSION['consultac']=1:$_SESSION['consultac']=0;
            in_array(7, $valores)?$_SESSION['consultav']=1:$_SESSION['consultav']=0;
        }
        echo json_encode($fetch);
        break;
        
    case 'salir':
        //Limpiamos la variable session
        session_unset();
        //Destruimos la sesión
        session_destroy();
        //Redirecionamos al login
        header("Location: ../index.php");
        
        break;
}
?>


