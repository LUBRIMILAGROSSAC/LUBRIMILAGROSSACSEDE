<?php require_once 'sesion.validar.vista.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Registrar Compras</title>
        <?php require_once 'metas.vista.php'; ?>
        <?php require_once 'estilos.vista.php'; ?>
                    <!-- AutoCompletar-->
	<link href="../util/jquery/jquery.ui.css" rel="stylesheet">
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
            <?php require_once 'menu.cabecera.vista.php'; ?>
            <!-- =============================================== -->

            <!-- Left side column. contains the sidebar -->
            <?php require_once 'menu.izquierda.vista.php'; ?>
            <!-- =============================================== -->
                    <!-- AutoCompletar-->
	<!--link href="../util/jquery/jquery.ui.css" rel="stylesheet">
            <!-- Content Wrapper. Contains page content -->
            <form id="frmgrabar">
                <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1 class="text-bold text-black" style="font-size: 20px;">Registrar nueva compra</h1>
                    <ol class="breadcrumb">
                        <button type="submit" class="btn btn-primary btn-sm">Registrar la Compra</button>
                    </ol>
                </section>

                <section class="content">
                    <div class="box box-success">
                        <div class="box-body">
                              <div class="row">
                                  <div class="col-xs-2">
                                      <div class="form-group">
                                        <label>Nº Compra</label>
                                        <input type="text" class="form-control input-sm" readonly="" id="txtnro" name="txtnro"/>
                                      </div>
                                  </div>

                                  <div class="col-xs-2">
                                      <div class="form-group">
                                        <label>Tipo Doc.</label>
                                        <select class="form-control input-sm" id="cbotipdoc" name="cbotipdoc" required="">
                                        </select>
                                      </div>
                                  </div>

                                  <div class="col-xs-2">
                                      <div class="form-group">
                                        <label>Serie</label>
                                        <input type="text" class="form-control input-sm" id="txtnroser" name="txtnroser" required=""/>
                                      </div>
                                  </div>

                                  <div class="col-xs-3">
                                      <div class="form-group">
                                        <label>Nº Documento</label>
                                        <input type="text" class="form-control input-sm" id="txtnrodoc" name="txtnrodoc" required=""/>
                                      </div>
                                  </div>

                                  <div class="col-xs-3">
                                      <div class="form-group">
                                        <label>Fecha de Compra</label>
                                        <input type="date" class="form-control input-sm" id="txtfec" name="txtfec" required="" value="<?php echo date('Y-m-d'); ?>"/>
                                      </div>
                                  </div>
                              </div><!-- /row -->
                              <div class="row">
                                  <div class="col-xs-9">
                                      <div class="form-group">
                                      <label>Seleccione un Proveedor</label>
                                          <div class="input-group">
                                        <input type="hidden" id="txtrucproveedor" name="txtrucproveedor">
                                     <input type="text" class="form-control input-sm" id="txtproveedor" >
                                        <span class="input-group-btn"><button class="btn btn-sm btn-warning " id="btnbuscar">Buscar</button></span>

                                        </div>
                                      </div>
                                      
                                  </div>
                                  <div class="col-xs-3">
                                      <div class="form-group">
                                        <label>IGV</label>
                                        <input type="text" class="form-control input-sm" id="txtigv" readonly="" name="txtigv" value="18">
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-xs-6">
                                      <div class="form-group">
                                        <label>Dirección:</label>
                                        <input type="text" class="form-control input-sm" id="lbldireccionproveedor" readonly="">
                                      </div>
                                  </div>
                                  <div class="col-xs-3">
                                      <div class="form-group">
                                        <label>Teléfono:</label>
                                        <input type="text" class="form-control input-sm" id="lbltelefonoproveedor" readonly="">
                                      </div>
                                  </div>

                              </div>
                          <!-- /row -->
                          </div>
                    </div>
                    
                    
                    <div class="box box-success">
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-xs-6">
                                      <div class="form-group">
                                        <label>Digite las iniciales de un artículo</label>
                                        <input type="text" class="form-control input-sm" id="txtarticulo" />
                                        <input type="hidden" id="txtcodigoarticulo" />
                                      </div>
                                  </div>
                                  <div class="col-xs-2">
                                      <div class="form-group">
                                        <label>Precio</label>
                                        <input type="text" class="form-control input-sm" id="txtprecio" readonly="" />
                                      </div>
                                  </div>
                                  <div class="col-xs-2">
                                      <div class="form-group">
                                        <label>Cantidad</label>
                                        <input type="text" class="form-control input-sm" id="txtcantidad" />
                                      </div>
                                  </div>
                                  <div class="col-xs-2">
                                      <div class="form-group">
                                        <label>&nbsp;</label>
                                        <br>
                                        <button type="button" class="btn btn-danger btn-sm" id="btnagregar">Agregar</button>
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-xs-12">
                                      <table id="tabla-listado" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>CÓDIGO</th>
                                                <th>ARTÍCULO</th>
                                                <th style="text-align: right">PRECIO</th>
                                                <th style="text-align: right">CANTIDAD</th>
                                                <th style="text-align: right">IMPORTE</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody id="detallecompra">

                                        </tbody>
                                            
                                        
                                        
                                    </table>
                                  </div>
                              </div>
                          </div>
                    </div>
                    <div class="box box-success">
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-xs-3">
                                      <div class="input-group">
                                        <span class="input-group-addon">SUB.TOTAL:</span>
                                        <input type="text" class="form-control text-right text-bold" id="txtimportesubtotal" name="txtimportesubtotal" readonly="" style="width: 100px;" />
                                      </div>
                                  </div>
                                  <div class="col-xs-3">
                                      <div class="input-group">
                                        <span class="input-group-addon">IGV:</span>
                                        <input type="text" class="form-control text-right text-bold" id="txtimporteigv" name="txtimporteigv" readonly="" style="width: 100px;"/>
                                      </div>
                                  </div>
                                  <div class="col-xs-3">
                                      <div class="input-group">
                                        <span class="input-group-addon">NETO:</span>
                                        <input type="text" class="form-control text-right text-bold" id="txtimporteneto" name="txtimporteneto" readonly="" style="width: 100px;"/>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>
                    
                </section>
            </div>
            </form>
            <!-- /.content-wrapper -->

            <?php require_once 'menu.pie.vista.php'; ?>

            <!-- Control Sidebar -->
            <?php require_once 'menu.derecha.vista.php'; ?>
            <!-- /.control-sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->

        <?php require_once 'scripts.vista.php'; ?>
        
       <!-- AutoCompletar -->
	<script src="../util/jquery/jquery.ui.autocomplete.js"></script>
	<script src="../util/jquery/jquery.ui.js"></script>
        <script src="js/compra.autocompletar.js" type="text/javascript"></script>
        
	<!--JS-->
        <script src="js/cargar-combos.js" type="text/javascript"></script>
        <script src="js/compra.js" type="text/javascript"></script>
        
    </body>
</html>