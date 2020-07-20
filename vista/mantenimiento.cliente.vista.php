<?php require_once 'sesion.validar.vista.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Mantenimiento de Clientes</title>
        <?php require_once 'metas.vista.php'; ?>
        <?php require_once 'estilos.vista.php'; ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
            <?php require_once 'menu.cabecera.vista.php'; ?>
            <!-- =============================================== -->

            <!-- Left side column. contains the sidebar -->
            <?php require_once 'menu.izquierda.vista.php'; ?>
            <!-- =============================================== -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Clientes
                    </h1>
                    <ol class="breadcrumb">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal" id="btnagregar"><i class="fa fa-copy"></i> Agregar Cliente</button>&nbsp;&nbsp;&nbsp;
                        <li><a href="#"><i class="fa fa-dashboard"></i> Menú Principal</a></li>
                        <li><a href="#">Mantenimientos</a></li>
                        <li class="active">Mantenimiento de Clientes</li>
                    </ol>
                </section>

                <!-- Main content -->
              <section class="content">
                  
                  <div class="row">
                    
                        <div class="col-xs-20 col-sm-20 col-md-20">
                            <div class="box box-default">
                                <div class="box-body">
                                    <div id="listado"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                      </div>
                      

                    <!-- INICIO del formulario modal -->
                    <small>
                        <form id="frmgrabar">
                            <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="titulomodal">Título de la ventana</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <p>
                                                        <input type="hidden" value="" id="txtTipoOperacion" name="txtTipoOperacion">
                                                        Código <input type="text" 
                                                                      name="txtCodigo" 
                                                                      id="txtCodigo" 
                                                                      class="form-control input-sm text-bold" 
                                                                      readonly="">
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <p>
                                                        Apellidos <input type="text" 
                                                                      name="txtApellidos" 
                                                                      id="txtApellidos" 
                                                                      class="form-control input-sm text-bold" required="">
                                                    </p>
                                                </div>
                                            
                                           
                                                <div class="col-xs-12">
                                                    <p>
                                                        Nombres <input type="text" 
                                                                      name="txtNombres" 
                                                                      id="txtNombres" 
                                                                      class="form-control input-sm text-bold" required="">
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <p>
                                                        Ruc/Dni <input type="text" 
                                                                      name="txtDni" 
                                                                      id="txtDni" 
                                                                      class="form-control input-sm text-bold" required="">
                                                    </p>
                                                </div>
                                           
                                           
                                                <div class="col-xs-6">
                                                    <p>
                                                        Direccion <input type="text" 
                                                                      name="txtDireccion" 
                                                                      id="txtDireccion" 
                                                                      class="form-control input-sm text-bold">
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <p>
                                                        Telefono <input type="text" 
                                                                      name="txtTelefonoFijo" 
                                                                      id="txtTelefonoFijo" 
                                                                      class="form-control input-sm text-bold">
                                                    </p>
                                                </div>
                                            
                                            
                                                <div class="col-xs-6">
                                                    <p>
                                                        Correo Electronico <input type="email" 
                                                                           name="txtEmail" 
                                                                           id="txtEmail" 
                                                                           class="form-control input-sm text-bold">
                                                    </p>
                                                </div>
                                            </div>
                                           
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <p>
                                                        Direccion web <input type="text" 
                                                                               name="txtDireccionWeb" 
                                                                               id="txtDireccionWeb" 
                                                                               class="form-control input-sm text-bold">
                                                    </p>
                                                </div>
                                                <div class="col-xs-6">
                                                    <p>
                                                        Tipo Cliente 
                                                        <select name="cboTipoDocumento" id="cboTipoDocumento" class="form-control input-sm" required="">
                                                            <option value="">Seleccione tipo cliente</option>
                                                            <option value="PERSONA NATURAL">PERSONA NATURAL</option>
                                                            <option value="PERSONA JURICA">PERSONA JURICA</option>
                                                            <option value="S.COMERCIAL DE RESPONSABILIDAD LIMITADA">S.COMERCIAL DE RESPONSABILIDAD LIMITADA</option>
                                                            <option value="S.INDIVIDUAL DE RESPONSABILIDAD LIMITADA">S.INDIVIDUAL DE RESPONSABILIDAD LIMITADA</option>
                                                            <option value="SOCIEDAD ANONIMA ABIERTA">SOCIEDAD ANONIMA ABIERTA</option>
                                                            <option value="SOCIEDAD ANONIMA CERRADA">SOCIEDAD ANONIMA CERRADA</option>
                                                        </select>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <p>
                                                        Distrito
                                                        <select name="cboDistrito" id="cboDistrito" class="form-control input-sm" required="">

                                                        </select>
                                                    </p>
                                                </div>
                                            </div>



                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" aria-hidden="true"><i class="fa fa-save"></i> Grabar</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal" id="btncerrar"><i class="fa fa-close"></i> Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </small>
                    <!-- FIN del formulario modal -->


                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <?php require_once 'menu.pie.vista.php'; ?>

            <!-- Control Sidebar -->
            <?php require_once 'menu.derecha.vista.php'; ?>
            <!-- /.control-sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->

        <?php require_once 'scripts.vista.php'; ?>
        
        <!-- Scripts para mantenimiento -->
        <script src="js/cargar.comboC.js" type="text/javascript"></script>
        <script src="js/mantenimiento.cliente.js" type="text/javascript"></script>
        
        
        
    </body>
</html>