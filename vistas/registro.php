<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ITS Ventas</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link href="../public/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- Font Awesome -->
    <link href="../public/css/font-awesome.css" rel="stylesheet" type="text/css"/>
   
    <!-- Theme style -->
    <link href="../public/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <!-- iCheck -->
    <link href="../public/css/blue.css" rel="stylesheet" type="text/css"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="../../index2.html"><b>ITS Ventas</b></a>
      </div><!-- /.login-logo -->
      <div class="panel-body" style="height: 400px;">
        <p class="login-box-msg">Ingrese sus datos de Registro</p>
        <form id="frmRegistro" method="post">
          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label>Nombre:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required="required">           
          </div>
          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label>Tipo Documento:</label>
            <select class="form-control selectpicker" name="tipo_documento" id="tipo_documento" required="required">
                <option>CI</option>
                <option>RUC</option>
                <option>Pasaporte</option>
            </select>
          </div>
          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label>Número Documento:</label>
            <input type="text" class="form-control" name="num_documento" id="num_documento" maxlength="20" placeholder="Número de Documento" required="required">
          </div>
          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label>Dirección:</label>
            <input type="text" class="form-control" name="direccion" id="direccion" maxlength="70" placeholder="Dirección" required="required">
          </div>
          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label>Teléfono:</label>
            <input type="tel" class="form-control" name="telefono" id="telefono" maxlength="20" placeholder="Teléfono" required="required">
          </div>
          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label>Email:</label>
            <input type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email" required="required">
          </div>
          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label>Confirme el Email:</label>
            <input type="email" class="form-control" name="email2" id="email2" maxlength="50" placeholder="Email" required="required">
          </div>
          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label>Cargo:</label>
            <select type="text" class="form-control" name="cargo" id="cargo" maxlength="20" placeholder="Cargo" required="required">
                <option>Gerente</option>
                <option>Administrador</option>
                <option>Vendedor</option>
            </select>
          </div>
          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label>Login:</label>
            <input type="text" class="form-control" name="login" id="login" maxlength="20" placeholder="Login" required="required">
          </div>
          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label>Clave:</label>
            <input type="password" class="form-control" name="clave" id="clave" maxlength="64" placeholder="Clave" required="required">
          </div>
          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label>Confirme su Clave:</label>
            <input type="password" class="form-control" name="clave2" id="clave2" maxlength="64" placeholder="Clave" required="required">
          </div>
          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label>Foto:</label>
            <input type="file" class="form-control" name="imagen" id="imagen">
            <input type="hidden" class="form-control" name="imagenactual" id="imagenactual">
            <img src="" width="150px" height="120px" name="imagenmuestra" id="imagenmuestra">
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

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="../public/js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../public/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../public/js/bootbox.min.js" type="text/javascript"></script>
    <script src="scripts/registro.js" type="text/javascript"></script>
  </body>
</html>