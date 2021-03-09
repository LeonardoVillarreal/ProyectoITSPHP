var tabla;

//Fución que se ejecute al inicio
function init(){
    mostrarForm(false);
    listar();
    
    $("#formulario").on("submit", function(e) {
        guardarYeditar(e);
    });
    
        $.post("../ajax/articulos.php?op=selectcategoria",function (r){
            $("#idcategoria").html(r);
            $("#idcategoria").selectpicker('refresh');
    });
    $("#imagenmuestra").hide();
}

//fución limpiar
function limpiar(){
    $("#codigo").val("");
    $("#nombre").val("");
    $("#stock").val("");
    $("#descripcion").val("");
    $("#imagenmuestra").attr('src',"");
    $("#imagenactual").val("");
    $("#print").hide();
    $("#idarticulo").val("");
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
                url:'../ajax/articulos.php?op=listar',
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
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);
    
    $.ajax({
        url : '../ajax/articulos.php?op=guardaryeditar',
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

function mostrar(idarticulo){
    $.post("../ajax/articulos.php?op=mostrar", {idarticulo : idarticulo}, function(data, status){
       data = JSON.parse(data);
        mostrarForm(true);
        $("#idcategoria").val(data.idcategoria);
        $("#idcategoria").selectpicker('refresh');
        $("#codigo").val(data.codigo);
        $("#nombre").val(data.nombre);
        $("#stock").val(data.stock);
        $("#descripcion").val(data.descripcion);
        $("#imagenmuestra").show();
        $("#imagenmuestra").attr("src","../files/articulos/"+data.imagen);
        $("#imagenactual").val(data.imagen);
        $("#idarticulo").val(data.idarticulo);
        generarBarCode();
    });
}

//Función para desactivar categoría
function desactivar(idarticulo){
    bootbox.confirm("¿Está seguro que deseas desactivar este artículo?", function(result){
        if(result){
          $.post("../ajax/articulos.php?op=desactivar", {idarticulo:idarticulo}, function(e){
              bootbox.alert(e);
              tabla.ajax.reload();
          });         
        }
    });
}
//Función para activar categoría
function activar(idarticulo){
    bootbox.confirm("¿Está seguro que deseas activar el artículo?", function(result){
        if(result){
          $.post("../ajax/articulos.php?op=activar", {idarticulo:idarticulo}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
          });
        }
    });
}

function generarBarCode(){
    codigo = $("#codigo").val();
    JsBarcode("#barcode",codigo);
}
//Función para imprimir el Código de barras
function imprimir()
{
	$("#print").printArea();
}
init();



