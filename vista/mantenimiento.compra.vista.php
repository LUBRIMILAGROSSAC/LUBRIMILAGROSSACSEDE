<?php require_once 'sesion.validar.vista.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Compras</title>
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
                    <h1 class="text-bold text-black" style="font-size: 20px;">Registro de Compras</h1>
                </section>

                <section class="content">
                    
                    <div class="row">
                        <div class="col-xs-12">
                    <form class="form-inline">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="rbtipo" id="rbtipo" value="1" checked="" >
                                              Solo Hoy
                                            </label>
                                        </div>
                                        &nbsp;&nbsp;
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="rbtipo" id="rbtipo" value="2">
                                              Rango de Fechas
                                            </label>
                                        </div>
                                        &nbsp;&nbsp;
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="rbtipo" id="rbtipo" value="3">
                                              Todas las Fechas
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                &nbsp;
                                
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="input-group">
                                            <label>Desde:&nbsp;</label>
                                            <div class="input-group">
                                              <input type="date" id="txtfecha1" class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>"/>
                                            </div><!-- /.input group -->
                                        </div><!-- /.form group -->
                                        &nbsp;&nbsp;
                                        <div class="input-group">
                                            <label>Hasta:&nbsp;</label>
                                            <div class="input-group">
                                                <input type="date" id="txtfecha2" class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>"/>
                                            </div><!-- /.input group -->
                                        </div><!-- /.form group -->

                                        &nbsp;
                                        <button type="button" class="btn btn-primary btn-sm" id="btnfiltrar">Filtrar Datos</button>

                                        &nbsp;
                                        <button type="button" class="btn btn-danger btn-sm" id="btnagregar">Agregar Nueva CompraJere</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                      <p>
                        <div class="box box-success">
                            <div class="box-body">
                                <div STYLE="overflow: auto;">
                                <div id="listado">
                                    
                                </div>
                            </div>
                        </div>
                            </div>
                    </p>
                </section>
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
            <?php require_once 'scripts.vista.php'; ?>
         <script src="js/compra.listado.js" type="text/javascript"></script>
        
    </body>
</html>