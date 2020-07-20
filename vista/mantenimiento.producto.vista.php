<?php require_once 'sesion.validar.vista.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Mantenimiento de Productos</title>
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
                        Productos
                    </h1>
                    <ol class="breadcrumb">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal" id="btnagregar"><i class="fa fa-copy"></i> Agregar producto</button>&nbsp;&nbsp;&nbsp;
                        <li><a href="#"><i class="fa fa-dashboard"></i> Menú Principal</a></li>
                        <li><a href="#">Mantenimientos</a></li>
                        <li class="active">Mantenimiento de Productos</li>
                    </ol>
                </section>

                <!-- Main content -->
                 <section class="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="box box-default">
                                <div class="box-body">
                                    <div id="listado"></div>
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
                                                        <label for="nombre">Codigo</label>
                                                        <input type="text" 
                                                                      name="txtCodigo" 
                                                                      id="txtCodigo" 
                                                                      class="form-control input-sm text-bold" 
                                                                      readonly="">
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <p>
                                                        <label for="nombre">Descripcion</label>
                                                        <input type="text" 
                                                                      name="txtNombre" 
                                                                      id="txtNombre" 
                                                                      class="form-control input-sm text-bold" required="">
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <p>
                                                        <label for="nombre"> Precio Venta</label>
                                                        <input type="number" 
                                                                               name="txtPrecioVenta" 
                                                                               id="txtPrecioVenta" 
                                                                               class="form-control input-sm text-bold" required="" step="any" min="0" max="99999">
                                                    </p>
                                                </div>
                                                <div class="col-xs-6">
                                                    <p>
                                                        
                                                       <label for="nombre">Familia</label>
                                                        <select name="cboTipoProducto" id="cboTipoProducto" class="form-control input-sm " required="">
                                                            <option value="Seleccione Tipo Producto">Seleccione Familia</option>
                                                            <option value="PRODUCTO">PRODUCTO</option>
                                                            <option value="SUMINISTRO">SUMINISTRO</option>
                                                            <option value="REPUESTO">REPUESTO</option>
                                                        </select>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <p>
                                                        <label for="nombre">Stock</label>
                                                        <input type="text" 
                                                                               name="txtStock" 
                                                                               id="txtStock" 
                                                                               class="form-control input-sm text-bold">
                                                    </p>
                                                </div>
                                                <div class="col-xs-6">
                                                    <p>
                                                        <label for="nombre">Categoria</label>
                                                        <select name="cboCategoria" id="cboCategoria" class="form-control input-sm">

                                                        </select>
                                                    </p>
                                                </div>
                                            </div>
                                             <div class="row">
                                                <div class="col-xs-12">
                                                    <p>
                                                        <label for="nombre">Marca</label>
                                                        <select name="cboMarca" id="cboMarca" class="form-control input-sm" required="">

                                                        </select>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <p>
                                                        <label for="nombre">Ubicacion</label>
                                                        <input type="text" 
                                                                      name="txtUbicacion" 
                                                                      id="txtUbicacion"
                                                                      class="form-control input-sm text-bold" required="">
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
        <script src="js/cargar.combo.js" type="text/javascript"></script>
        <script src="js/cargar.comboM.js" type="text/javascript"></script>
        <script src="js/mantenimiento.producto.js" type="text/javascript"></script>
        
    </body>
</html>