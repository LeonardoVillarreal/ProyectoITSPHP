<?php
   require 'header.php'; 
    ?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">Detalle de Ventas <button id="btnAgregar" class="btn btn-success" onclick="mostrarForm(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th>Opciones</th>
                                <th>Comprobante</th>
                                <th>Artículo</th>
                                <th>Cantidad</th>
                                <th>Precio de venta</th>
                                <th>Descuento</th>                                
                                <th>Estado</th>
                            </thead>
                            <tbody>
                                
                            </tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Comprobante</th>
                                <th>Artículo</th>
                                <th>Cantidad</th>
                                <th>Precio de venta</th>
                                <th>Descuento</th>                                
                                <th>Estado</th>
                            </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Comprobante:</label>
                            <input type="hidden" name="iddetalle_venta" id="iddetalle_venta">                     
                            <select class="form-control selectpicker" name="idventa" id="idventa" data-live-search="true" required="required"></select>
                          </div>                          
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Artículo:</label>
                            <select id="idarticulo" name="idarticulo" class="form-control selectpicker" data-live-search="true" required="required"></select>
                          </div>                        
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cantidad:</label>
                            <input type="number" class="form-control" name="cantidad" id="cantidad" required="required">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Precio de venta:</label>
                            <input type="text" class="form-control" name="precio_venta" id="precio_venta">
                          </div>       
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Descuento:</label>
                            <input type="text" class="form-control" name="descuento" id="descuento">
                          </div>    
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-primary" type="submit" id="btnGuardar">
                                    <i class="fa fa-save"></i> Guardar
                                </button>
                            <button class="btn btn-danger" onclick="cancelarForm()" type="button">
                                <i class="fa fa-arrow-circle-left"></i> Cancelar
                            </button>
                          </div>
                        </form>
                    </div>
                    
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
  
  
  <?php
   require 'footer.php'; 
    ?>
  <script src="scripts/detalle_venta.js" type="text/javascript"></script>
