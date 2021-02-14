var tabla;

//Fución que se ejecute al inicio
function init(){
    mostrarForm(false);
    listar();
    
    $("#formulario").on("submit", function(e) {
        guardarYeditar(e);
    });
    
    $.post("../ajax/ingresos.php?op=selectproveedor",function (r){
        $("#idproveedor").html(r);
        $("#idproveedor").selectpicker('refresh');
    });
    
    $.post("../ajax/ingresos.php?op=selectusuario",function (r){
            $("#idusuario").html(r);
            $("#idusuario").selectpicker('refresh');
    });
}

//fución limpiar
function limpiar(){
    $("#idingreso").val("");
    $("#idproveedor").val("");
    $("#idusuario").val("");
    $("#tipo_comprobante").val("");
    $("#serie_comprobante").val("");
    $("#num_comprobante").val("");
    $("#fecha_hora").val("");
    $("#impuesto").val("");
    $("#total_compra").val("");
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
                url:'../ajax/ingresos.php?op=listar',
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
        url : '../ajax/ingresos.php?op=guardaryeditar',
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

function mostrar(idingreso){
    $.post("../ajax/ingresos.php?op=mostrar", {idingreso : idingreso}, function(data, status){
       data = JSON.parse(data);
        mostrarForm(true);
        $("#idproveedor").val(data.idproveedor);
        $("#idproveedor").selectpicker('refresh');
        $("#idusuario").val(data.idusuario);
        $("#idusuario").selectpicker('refresh');
        $("#tipo_comprobante").val(data.tipo_comprobante);
        $("#serie_comprobante").val(data.serie_comprobante);
        $("#num_comprobante").val(data.num_comprobante);
        $("#fecha_hora").val(data.fecha_hora);
        $("#impuesto").val(data.impuesto);
        $("#total_compra").val(data.total_compra);
        $("#idingreso").val(data.idingreso);
    });
}

//Función para desactivar categoría
function desactivar(idingreso){
    bootbox.confirm("¿Está seguro que deseas desactivar este ingreso?", function(result){
        if(result){
          $.post("../ajax/ingresos.php?op=desactivar", {idingreso:idingreso}, function(e){
              bootbox.alert(e);
              tabla.ajax.reload();
          });         
        }
    });
}
//Función para activar categoría
function activar(idingreso){
    bootbox.confirm("¿Está seguro que deseas activar el ingreso?", function(result){
        if(result){
          $.post("../ajax/ingresos.php?op=activar", {idingreso:idingreso}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
          });
        }
    });
}

init();

