<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo $foto; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $sesion_nombre_usuario; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> En Linea</a>
            </div>
        </div>
        <!-- search form -->
     
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU PRINCIPAL</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>Mantenimientos</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="mantenimiento.producto.vista.php"><i class="fa fa-circle-o"></i> Productos</a></li>
                    <li><a href="mantenimiento.categoria.vista.php"><i class="fa fa-circle-o"></i> Categorías</a></li>
                    <li><a href="mantenimiento.marca.vista.php"><i class="fa fa-circle-o"></i> Marcas</a></li>
                    <li><a href="mantenimiento.proveedor.vista.php"><i class="fa fa-circle-o"></i> Proveedores</a></li>
                    <li><a href="mantenimiento.cliente.vista.php"><i class="fa fa-circle-o"></i> Clientes</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Transacciones</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="mantenimiento.compra.vista.php"><i class="fa fa-circle-o"></i> Compras</a></li>
                    <li><a href=""><i class="fa fa-circle-o"></i> Ventas</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Notas de Credito</a></li>
                </ul>
            </li>
            
             <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Almacen</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Stock de productos</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Inventarios</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Modulos</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-table"></i> <span>Contabilidad</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Ingresos y Egresos </a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Balance General</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Estados de Resultados</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Inversiones</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Flujo de Caja</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Administracion</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Personal</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Gerencias</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-table"></i> <span>Reportes</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Reporte de Ventas</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Reporte de Compras</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Reporte Ventas Anuladas</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Reporte de Compras Anuladas</a></li>
                </ul>
            </li>
            

            <li class="header">Graficos</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Importante</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Graficos</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Informacion</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Usuarios en Linea</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>