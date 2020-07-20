//JQuery
$("#btnbuscar").click(function(){
    listar();
    });

$(document).ready(function(){
    //alert("Se esta ejecutando código en JS");
    listar();
    cargarComboCategoria("#cboCategoria", "s");
    cargarComboMarca("#cboMarca", "m");
    
});


function listar(){
    $.post
    (
        "../controlador/producto.listar.controlador.php"
    ).done(function(resultado){
        var datosJSON = resultado;
        if (datosJSON.estado === 200){//Validamos si el controlador se ha ejecutado correctamente
            var html = "";
            html += '<small>';
            html += '<div class="table-responsive">';
            html += '<table id="tabla-listado" class="table table-bordered  table-bordered table-hover">';
            html += '<thead>';
            html += '<th>NUM</th>';
            html += '<th>NOMBRE</th>';
            html += '<th>P.COMPRA</th>';
            html += '<th>P.VENTA</th>';
            html += '<th>TIP.PRODUCTO</th>';
            html += '<th>CATEGORIA</th>';
            html += '<th>LINEA</th>';
            html += '<th>MARCA</th>';
            html += '<th>STOCK</th>';
            html += '<th>UBICACION</th>';
	    html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            
            //Detalle
            $.each(datosJSON.datos, function(i,item) {
                html += '<tr>';
                html += '<td align="center">'+item.codigo_producto+'</td>';
                html += '<td>'+item.nombre+'</td>';
                html += '<td>'+item.precio_compra+'</td>';
                html += '<td>'+item.precio_venta+'</td>';
                html += '<td>'+item.tipo_producto+'</td>';
                html += '<td>'+item.categoria+'</td>';
                html += '<td>'+item.linea+'</td>';
                html += '<td>'+item.marca+'</td>';
                html += '<td>'+item.stock+'</td>';
                html += '<td>'+item.ubicacion+'</td>';
		html += '<td align="center">';
		html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.codigo_producto + ')"><i class="fa fa-pencil"></i></button>';
		html += '&nbsp;&nbsp;';
		html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.codigo_producto + ')"><i class="fa fa-close"></i></button>';
		html += '</td>';
                html += '</tr>';
            });
            
            html += '</tbody>';
            html += '</table>';
            html += '</div>';
            html += '</small>';
            
            
            //Mostrar el resultado de la variable html en el div "listado"
            $("#listado").html(html);
            
            //Aplicar la función dataTable a la tabla donde se muestra el resultadoi
            $('#tabla-listado').dataTable({
                "aaSorting": [[1, "asc"]]
            });
            
        }
    }).fail(function(error){
        var datosJSON = $.parseJSON( error.responseText );
        swal("Ocurrió un error", datosJSON.mensaje , "error"); 
        
    });
    
    
}


function eliminar(codigo_producto){
    swal({
            title: "Confirme",
            text: "¿Esta seguro de eliminar el registro?",
            showCancelButton: true,
            confirmButtonColor: '#d93f1f',
            confirmButtonText: 'Si',
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true,
            imageUrl: "../imagenes/eliminar2.png"
    },
    function(isConfirm){
        if (isConfirm){ //el usuario hizo clic en el boton SI     
            $.post
            (
                "../controlador/producto.eliminar.controlador.php",
                {
                    p_cod_pr: codigo_producto
                }
            ).done(function(resultado){
                var datosJSON = resultado;

                if (datosJSON.estado === 200){
                    swal("Exito", datosJSON.mensaje, "success");
                    listar(); //actualizar la lista
                }else{
                  swal("Mensaje del sistema", resultado , "warning");
                }
            }).fail(function(error){
               var datosJSON = $.parseJSON( error.responseText );
               swal("Ocurrió un error", datosJSON.mensaje , "error");
            });
        }
    });
}


$("#btnagregar").click(function(){
    $("#txtTipoOperacion").val("agregar");
    $("#titulomodal").html("Agregar un nuevo producto");
    $("#txtCodigo").val("");
    $("#txtNombre").val("");
    $("#txtPrecioVenta").val("");
    $("#cboTipoProducto").val("");
    $("#txtStock").val("");
    $("#cboCategoria").val("");
    $("#cboMarca").val("");
    $("#txtUbicacion").val("");
    

    
});


$("#myModal").on("shown.bs.modal", function(){
    $("#txtNombre").focus();
});
 


$("#frmgrabar").submit(function(event){
    event.preventDefault();
    
    swal({
            title: "Confirme",
            text: "¿Esta seguro de grabar los datos ingresados?",
            showCancelButton: true,
            confirmButtonColor: '#3d9205',
            confirmButtonText: 'Si',
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true,
            imageUrl: "../imagenes/preguntar.png"
    },
    function(isConfirm){ 
        if (isConfirm){ //el usuario hizo clic en el boton SI   
            
            var v_tipo_operacion = $("#txtTipoOperacion").val();
            var v_cod_pro = "";
            
            if (v_tipo_operacion==="agregar"){
                v_cod_pro = "nuevo";
            }else{
                v_cod_pro = $("#txtCodigo").val();
            }
            
            var v_nombre = $("#txtNombre").val();
            var v_precio_venta = $("#txtPrecioVenta").val();
            var v_tipo_producto = $("#cboTipoProducto").val();
            var v_stock = $("#txtStock").val();
            var v_categoria = $("#cboCategoria").val();
            var v_marca = $("#cboMarca").val();
            var v_ubicacion = $("#txtUbicacion").val();
            
            
            $.post
                (
                    "../controlador/producto.agregar.editar.controlador.php",
                    {
                        p_cod_pr : v_cod_pro,
                        p_nombre : v_nombre,
                        p_precio_venta : v_precio_venta,
                        p_tipo_producto : v_tipo_producto,
                        p_stock : v_stock,
                        p_codigo_categoria : v_categoria,
                        p_codigo_marca : v_marca,
                        p_ubicacion : v_ubicacion,
                        p_tipo_operacion : v_tipo_operacion
                        
                        
                    }
                ).done(function(resultado){
                    var datosJSON = resultado;
                    
                    if (datosJSON.estado === 200){
                        swal("Exito", datosJSON.mensaje, "success");
                        $("#btncerrar").click(); //Cerrar la ventana 
                        listar(); //actualizar la lista
                    }else{
                      swal("Mensaje del sistema", resultado , "warning");
                    }
                }).fail(function(error){
                   var datosJSON = $.parseJSON( error.responseText );
                   swal("Ocurrió un error", datosJSON.mensaje , "error");
                });
        }
    });
    
});
function leerDatos(codigo_producto) {
    //alert(codigo_producto);
    $.post
        (
            "../controlador/producto.leer.datos.controlador.php",
            {
                 p_cod_pr: codigo_producto
            }
        ).done(function(resultado){
            var datosJSON = resultado;

            if (datosJSON.estado === 200){
                $("#txtTipoOperacion").val("editar");
                $("#txtCodigo").val(datosJSON.datos.codigo_producto);
                $("#txtNombre").val(datosJSON.datos.nombre);
                $("#txtPrecioVenta").val(datosJSON.datos.precio_venta);
                $("#cboTipoProducto").val(datosJSON.datos.tipo_producto);
                $("#txtStock").val(datosJSON.datos.stock);
                $("#cboCategoria").val(datosJSON.datos.codigo_categoria);
                $("#cboMarca").val(datosJSON.datos.codigo_marca);
                $("#txtUbicacion").val(datosJSON.datos.ubicacion);
               $("#titulomodal").html("Editar datos de producto");
                
            }else{
              swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
           var datosJSON = $.parseJSON( error.responseText );
           swal("Ocurrió un error", datosJSON.mensaje , "error");
        });
}
