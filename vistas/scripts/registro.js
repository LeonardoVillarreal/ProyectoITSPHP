var tabla;
var error="";
function init(){   
    $("#frmRegistro").on("submit", function(e) {
        comprobar();
        if(error!=""){
            bootbox.alert(error);
        }else{
            guardarYeditar(e);            
        }
        
    });
    header('Location: login.html');
}
function limpiar(){
    $("#idusuario").val("");
    $("#nombre").val("");
    $("#num_documento").val("");
    $("#direccion").val("");
    $("#telefono").val("");
    $("#email").val("");
    $("#email2").val("");
    $("#cargo").val("");
    $("#login").val("");
    $("#clave").val("");
    $("#clave2").val("");
    $("#imagenmuestra").attr('src',"");
    $("#imagenactual").val("");
}

function cancelarForm(){
    limpiar();
}
function guardarYeditar(e){
    e.preventDefault();//No se ejecuta la acción predeterminada
    $('#btnGuardar').prop("disabled",true);
    var formData = new FormData($("#frmRegistro")[0]);
    
    $.ajax({
        url : '../ajax/usuarios.php?op=guardar',
        type : "POST",
        data: formData,
        contentType: false,
        processData: false
        
//        success: function(datos){
//            confirm(datos);
//            window.location.href='../index.php';
//        }
    });
    limpiar();
}
function comprobar(){
    if($("#email").val()!=$("#email2").val()){
        error=error+'\nDebe ingresar el mismo correo en ambos campos';
    }else if($("#clave").val()!=$("#clave2").val()){
        error=error+'\nDebe ingresar la misma clave en ambos campos';
    }
}
init();
