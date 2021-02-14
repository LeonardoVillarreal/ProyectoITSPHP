var tabla;

//Fución que se ejecute al inicio
function init(){
    mostrarForm(false);
    listar();
    
    $("#formulario").on("submit", function(e) {
        guardarYeditar(e);
    });
    
    $.post("../ajax/ventas.php?op=selectcliente",function (r){
        $("#idcliente").html(r);
        $("#idcliente").selectpicker('refresh');
    });
    
    $.post("../ajax/ventas.php?op=selectusuario",function (r){
            $("#idusuario").html(r);
            $("#idusuario").selectpicker('refresh');
    });
}

//fución limpiar
function limpiar(){
    $("#idventa").val("");
    $("#idcliente").val("");
    $("#idusuario").val("");
    $("#tipo_comprobante").val("");
    $("#serie_comprobante").val("");
    $("#num_comprobante").val("");
    $("#fecha_hora").val("");
    $("#impuesto").val("");
    $("#total_venta").val("");
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
                url:'../ajax/ventas.php?op=listar',
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
        url : '../ajax/ventas.php?op=guardaryeditar',
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

function mostrar(idventa){
    $.post("../ajax/ventas.php?op=mostrar", {idventa : idventa}, function(data, status){
       data = JSON.parse(data);
        mostrarForm(true);
        $("#idcliente").val(data.idcliente);
        $("#idcliente").selectpicker('refresh');
        $("#idusuario").val(data.idusuario);
        $("#idusuario").selectpicker('refresh');
        $("#tipo_comprobante").val(data.tipo_comprobante);
        $("#serie_comprobante").val(data.serie_comprobante);
        $("#num_comprobante").val(data.num_comprobante);
        $("#fecha_hora").val(data.fecha_hora);
        $("#impuesto").val(data.impuesto);
        $("#total_venta").val(data.total_venta);
        $("#idventa").val(data.idventa);
    });
}

//Función para desactivar categoría
function desactivar(idventa){
    bootbox.confirm("¿Está seguro que deseas desactivar esta venta?", function(result){
        if(result){
          $.post("../ajax/ventas.php?op=desactivar", {idventa:idventa}, function(e){
              bootbox.alert(e);
              tabla.ajax.reload();
          });         
        }
    });
}
//Función para activar categoría
function activar(idventa){
    bootbox.confirm("¿Está seguro que deseas activar esta venta?", function(result){
        if(result){
          $.post("../ajax/ventas.php?op=activar", {idventa:idventa}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
          });
        }
    });
}

init();

