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
                        <h1 class="box-title">Ingresos <button id="btnAgregar" class="btn btn-success" onclick="mostrarForm(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th>Opciones</th>
                                <th>Número de comprobante</th>
                                <th>Serie de comprobante</th>
                                <th>Tipo de comprobante</th>
                                <th>Proveedor</th>
                                <th>Usuario</th>                                
                                <th>Fecha y hora</th>
                                <th>Impuesto</th>
                                <th>Total</th>
                                <th>Estado</th>
                            </thead>
                            <tbody>
                                
                            </tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Número de comprobante</th>
                                <th>Serie de comprobante</th>
                                <th>Tipo de comprobante</th>
                                <th>Proveedor</th>
                                <th>Usuario</th>                                
                                <th>Fecha y hora</th>
                                <th>Impuesto</th>
                                <th>Total</th>
                                <th>Estado</th>
                            </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Número de comprobante:</label>
                            <input type="hidden" name="idingreso" id="idingreso">
                            <input type="text" class="form-control" name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Número de comprobante" required="required">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Serie de comprobante:</label>
                            <input type="text" class="form-control" name="serie_comprobante" id="serie_comprobante" maxlength="7" placeholder="Serie de comprobante" required="required">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tipo de comprobante:</label>
                            <select class="form-control" name="tipo_comprobante" id="tipo_comprobante" required="required">
                                <option>Factura</option>
                                <option>Nota de Venta</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Proveedor:</label>
                            <select id="idproveedor" name="idproveedor" class="form-control selectpicker" data-live-search="true" required="required"></select>
                          </div>  
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Usuario:</label>
                            <select id="idusuario" name="idusuario" class="form-control selectpicker" data-live-search="true" required="required"></select>
                          </div>  
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha y Hora:</label>
                            <input type="datetime" class="form-control" name="fecha_hora" id="fecha_hora" required="required">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Impuesto:</label>
                            <input type="text" class="form-control" name="impuesto" id="impuesto">
                          </div>       
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Total:</label>
                            <input type="text" class="form-control" name="total_compra" id="total_compra">
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
  <script src="scripts/ingreso.js" type="text/javascript"></script>
