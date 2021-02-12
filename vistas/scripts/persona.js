var tabla;

//Fución que se ejecute al inicio
function init(){
    mostrarForm(false);
    listar();
    
    $("#formulario").on("submit", function(e) {
        guardarYeditar(e);
    });
}

//fución limpiar
function limpiar(){
    $("#idpersona").val("");
    $("#tipo_persona").val("");
    $("#nombre").val("");
    $("#tipo_documento").val("");
    $("#num_documento").val("");
    $("#direccion").val("");
    $("#telefono").val("");
    $("#email").val("");
}

//función mostrar formulario
function mostrarForm(flag){
    limpiar();
    if(flag){
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled",false);
    }else{
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
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
                url:'../ajax/personas.php?op=listar',
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
        url : '../ajax/personas.php?op=guardaryeditar',
        type : "POST",
        data: formData,
        contentType: false,
        processData: false,
        
        success: function(datos){
            bootbox.alert(datos);
            mostrarForm(false);
            tabla.ajax.reload();
        }
    });
    limpiar();
}

function mostrar(idpersona){
    $.post("../ajax/personas.php?op=mostrar", {idpersona : idpersona}, function(data, status){
       data = JSON.parse(data);
        mostrarForm(true);
        $("#tipo_persona").val(data.tipo_persona);
        $("#nombre").val(data.nombre);
        $("#tipo_documento").val(data.tipo_documento);
        $("#num_documento").val(data.num_documento);
        $("#direccion").val(data.direccion);
        $("#telefono").val(data.telefono);
        $("#email").val(data.email);
        $("#idpersona").val(data.idpersona);
    });
}

//Función para desactivar categoría
function desactivar(idpersona){
    bootbox.confirm("¿Está seguro que deseas desactivar esta persona?", function(result){
        if(result){
          $.post("../ajax/personas.php?op=desactivar", {idpersona:idpersona}, function(e){
              bootbox.alert(e);
              tabla.ajax.reload();
          });         
        }
    });
}
//Función para activar categoría
function activar(idpersona){
    bootbox.confirm("¿Está seguro que deseas activar esta persona?", function(result){
        if(result){
          $.post("../ajax/personas.php?op=activar", {idpersona:idpersona}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
          });
        }
    });
}
init();


