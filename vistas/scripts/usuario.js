var tabla;

//Fución que se ejecute al inicio
function init(){
    mostrarForm(false);
    listar();
    
    $("#formulario").on("submit", function(e) {
        guardarYeditar(e);
    });
    $("#imagenmuestra").hide();
    $.post("../ajax/usuarios.php?op=permisos&id=", function (r){
        $("#permisos").html(r);
    });
}

//fución limpiar
function limpiar(){
    $("#idusuario").val("");
    $("#nombre").val("");
    $("#num_documento").val("");
    $("#direccion").val("");
    $("#telefono").val("");
    $("#email").val("");
    $("#cargo").val("");
    $("#login").val("");
    $("#clave").val("");
    $("#imagenmuestra").attr('src',"");
    $("#imagenactual").val("");
}

//función mostrar formulario
function mostrarForm(flag){
    limpiar();
    if(flag){
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled",false);
        $("#btnAgregar").hide();
    }else{
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnAgregar").show();
    }
}

function cancelarForm(){
    limpiar();
    mostrarForm(false);
}

//función listar
function listar(){
    tabla =$('#tbllistado').dataTable({
            "aProcessing":true,//activa el procesamiento de datatables
            "aServerSide":true,//existe paginación y filtrado realizados por el servidor
            dom:'Bfrtip',//Definir los elementos de control de la tabla
            buttons:[
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],
            "ajax":{
                url:'../ajax/usuarios.php?op=listar',
                type:"get",
                dataType:"json",
                error:function(e){
                    console.log(e.responseText);
                }
            },
            "bDestroy":true,
            "iDisplayLength":5,
            "order":[[0,"desc"]]
        }).DataTable();
}

function guardarYeditar(e){
    e.preventDefault();//No se ejecuta la acción predeterminada
    $('#btnGuardar').prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);
    
    $.ajax({
        url : '../ajax/usuarios.php?op=guardaryeditar',
        type : "POST",
        data: formData,
        contentType: false,
        processData: false,
        
        success: function(datos){
            confirm(datos);
            window.location.href='../index.php';
            mostrarForm(false);
            tabla.ajax.reload();
        }
    });
    limpiar();
}

function mostrar(idusuario){
    
    $.post("../ajax/usuarios.php?op=mostrar", {idusuario : idusuario}, function(data, status){
       data = JSON.parse(data);
        mostrarForm(true);       
        $("#nombre").val(data.nombre);
        $("#tipo_documento").val(data.tipo_documento);
        $("#tipo_documento").selectpicker('refresh');
        $("#num_documento").val(data.num_documento);
        $("#direccion").val(data.direccion);
        $("#telefono").val(data.telefono);
        $("#email").val(data.email);
        $("#cargo").val(data.cargo);
        $("#cargo").selectpicker('refresh');
        $("#login").val(data.login);       
        $("#imagenmuestra").show();
        $("#imagenmuestra").attr("src","../files/usuarios/"+data.imagen);
        $("#imagenactual").val(data.imagen);
        $("#idusuario").val(data.idusuario);
    });
    $.post("../ajax/usuarios.php?op=permisos&id="+idusuario, function (r){
        $("#permisos").html(r);
    });
}

//Función para desactivar categoría
function desactivar(idusuario){
    bootbox.confirm("¿Está seguro que deseas desactivar este usuario?", function(result){
        if(result){
          $.post("../ajax/usuarios.php?op=desactivar", {idusuario:idusuario}, function(e){
              bootbox.alert(e);
              tabla.ajax.reload();
          });         
        }
    });
}
//Función para activar categoría
function activar(idusuario){
    bootbox.confirm("¿Está seguro que deseas activar este usuario?", function(result){
        if(result){
          $.post("../ajax/usuarios.php?op=activar", {idusuario:idusuario}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
          });
        }
    });
}
init();


