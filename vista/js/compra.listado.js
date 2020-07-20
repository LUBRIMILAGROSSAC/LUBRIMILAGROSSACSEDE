//JQuery
$(document).ready(function(){
    listar();
})

$("#btnfiltrar").click(function(){
    listar();
})

$("#btnagregar").click(function(){
    document.location.href="compra.vista.php";
})



function listar(){
    var tipo = $("#rbtipo:checked").val();
    var fecha1 = $("#txtfecha1").val();
    var fecha2 = $("#txtfecha2").val();
    
    $.post
    (
        "../controlador/compra.listar.controlador.php",
        {
            p_fecha1: fecha1,
            p_fecha2: fecha2,
            p_tipo: tipo
        }
    ).done(function(resultado){
        var datosJSON = resultado;
        if (datosJSON.estado === 200){ //Validamos si el controlador se ha ejecutado correctamente
            var html = "";
            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>N.COMP</th>';
            html += '<th>TIPO.DOC</th>';
            html += '<th>SERIE</th>';
            html += '<th>NÚMERO</th>';
            html += '<th>RUC</th>';
            html += '<th>RAZÓN SOCIAL</th>';
            html += '<th>FECHA</th>';
            html += '<th>SUB.TOTAL</th>';
            html += '<th>IGV</th>';
            html += '<th>TOTAL</th>';
            html += '<th>IMPUESTO</th>';
            html += '<th>DNI USUARIO</th>';
            html += '<th>F.REGISTRO</th>';
            html += '<th>H.REGISTRO</th>';
            html += '<th>ESTADO</th>';
	    html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            
            //Detalle
            $.each(datosJSON.datos, function(i,item) {
                html += '<tr>';
                html += '<td align="center">'+item.nro_compra+'</td>';
                html += '<td>'+item.tipo_doc+'</td>';
                html += '<td>'+item.serie+'</td>';
                html += '<td>'+item.documento+'</td>';
                html += '<td>'+item.ruc+'</td>';
                html += '<td>'+item.razon_social+'</td>';
                html += '<td>'+item.fecha+'</td>';
                html += '<td>'+item.sub_total+'</td>';
                html += '<td>'+item.igv+'</td>';
                html += '<td>'+item.total+'</td>';
                html += '<td>'+item.impuesto+'</td>';
                html += '<td>'+item.dni_usuario+'</td>';
                html += '<td>'+item.fecha_registro+'</td>';
                html += '<td>'+item.hora_registro+'</td>';
                html += '<td>'+item.estado+'</td>';
		html += '<td align="center">';
		html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.nro_compra + ')"><i class="fa fa-pencil"></i></button>';
		html += '&nbsp;&nbsp;';
		html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.nro_compra + ')"><i class="fa fa-close"></i></button>';
		html += '</td>';
                html += '</tr>';
            });
            
            html += '</tbody>';
            html += '</table>';
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
    $("#txtPrecioVenta").val("");
   // $("#cboTipoProducto").val("");
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
                        p_codigo_categoria : v_categoria,
                        p_codigo_marca : v_marca,
                        p_tipo_operacion : v_tipo_operacion,
                        p_ubicacion : v_ubicacion
                        
                        
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
