var tabla;

//Fución que se ejecute al inicio
function init(){
    mostrarForm(false);
    listar();
    
    $("#formulario").on("submit", function(e) {
        guardarYeditar(e);
    });
    
    $.post("../ajax/detalle_ventas.php?op=selectventa",function (r){
        $("#idventa").html(r);
        $("#idventa").selectpicker('refresh');
    });
    
    $.post("../ajax/detalle_ventas.php?op=selectarticulo",function (r){
            $("#idarticulo").html(r);
            $("#idarticulo").selectpicker('refresh');
    });
}

//fución limpiar
function limpiar(){
    $("#iddetalle_venta").val("");
    $("#idventa").val("");
    $("#idarticulo").val("");
    $("#cantidad").val("");
    $("#precio_venta").val("");
    $("#descuento").val("");

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
                url:'../ajax/detalle_ventas.php?op=listar',
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
        url : '../ajax/detalle_ventas.php?op=guardaryeditar',
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

function mostrar(iddetalle_venta){
    $.post("../ajax/detalle_ventas.php?op=mostrar", {iddetalle_venta : iddetalle_venta}, function(data, status){
       data = JSON.parse(data);
        mostrarForm(true);
        $("#idventa").val(data.idventa);
        $("#idventa").selectpicker('refresh');
        $("#idarticulo").val(data.idarticulo);
        $("#idarticulo").selectpicker('refresh');
        $("#cantidad").val(data.cantidad);
        $("#precio_venta").val(data.precio_venta);
        $("#descuento").val(data.descuento);
        $("#iddetalle_venta").val(data.iddetalle_venta);
    });
}

//Función para desactivar categoría
function desactivar(iddetalle_venta){
    bootbox.confirm("¿Está seguro que deseas desactivar este detalle de venta?", function(result){
        if(result){
          $.post("../ajax/detalle_ventas.php?op=desactivar", {iddetalle_venta:iddetalle_venta}, function(e){
              bootbox.alert(e);
              tabla.ajax.reload();
          });         
        }
    });
}
//Función para activar categoría
function activar(iddetalle_venta){
    bootbox.confirm("¿Está seguro que deseas activar este detalle de venta?", function(result){
        if(result){
          $.post("../ajax/detalle_ventas.php?op=activar", {iddetalle_venta:iddetalle_venta}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
          });
        }
    });
}

init();

