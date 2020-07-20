//JQuery

$(document).ready(function(){
    //alert("Se esta ejecutando código en JS");
    listar();
    //cargarComboCategoria("#cboCategoria", "s");
    //cargarComboMarca("#cboMarca", "m");
    
});


function listar(){
    $.post
    (
        "../controlador/proveedor.listar.controlador.php"
    ).done(function(resultado){
        var datosJSON = resultado;
        if (datosJSON.estado === 200){ //Validamos si el controlador se ha ejecutado correctamente
            var html = "";
            html += '<small>';
            html += '<div class="table-responsive">';
            html += '<table id="tabla-listado" class="table table-bordered  table-bordered table-hover">';
            html += '<thead>';
            html += '<tr class = "danger"style="background-color: #ededed; height:25px; ">';
            html += '<th>RUC</th>';
            html += '<th>RAZON.SOCIAL</th>';
            html += '<th>DIRECCION</th>';
            html += '<th>TELEFONO</th>';
            html += '<th>REPRESENTANTE</th>';
	    html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            
            //Detalle
            $.each(datosJSON.datos, function(i,item) {
                html += '<tr>';
                html += '<td align="center">'+item.ruc_proveedor+'</td>';
                html += '<td>'+item.razon_social+'</td>';
                html += '<td>'+item.direccion+'</td>';
                html += '<td>'+item.telefono+'</td>';
                html += '<td>'+item.representante_legal+'</td>';
		html += '<td align="center">';
		html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.ruc_proveedor + ')"><i class="fa fa-pencil"></i></button>';
		html += '&nbsp;&nbsp;';
		html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.ruc_proveedor + ')"><i class="fa fa-close"></i></button>';
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


function eliminar(codigo_proveedor){
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
                "../controlador/proveedor.eliminar.controlador.php",
                {
                    p_ruc_proveedor: codigo_proveedor
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
    $("#txtRuc").val("");
    $("#txtRazonSocial").val("");
   // $("#cboTipoProducto").val("");
       $("#txtDireccion").val("");
    $("#txtTelefono").val("");
    $("#txtRepresentanteLegal").val("");
    

    
});


$("#myModal").on("shown.bs.modal", function(){
    $("#txtRuc").focus();
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
                v_cod_pro 
            }else{
                v_cod_pro = $("#txtCodigo").val();
            }
            
            var v_ruc = $("#txtRuc").val();
            var v_razon_social = $("#txtRazonSocial").val();
            var v_direccion = $("#txtDireccion").val();
            var v_telefono = $("#txtTelefono").val();
            var v_representante_legal = $("#txtRepresentanteLegal").val();
            
            $.post
           
                (
                    "../controlador/proveedor.agregar.editar.controlador.php",
                    {
                        p_ruc_proveedor : v_ruc,
                        p_razon_social : v_razon_social,
                        p_direccion : v_direccion,
                        p_telefono : v_telefono,
                        p_representante_legal : v_representante_legal,
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
function leerDatos(codigo_proveedor) {
    //alert(codigo_producto);
    $.post
        (
            "../controlador/proveedor.leer.datos.controlador.php",
            {
                 p_ruc_proveedor: codigo_proveedor
            }
        ).done(function(resultado){
            var datosJSON = resultado;

            if (datosJSON.estado === 200){
                $("#txtTipoOperacion").val("editar");
                $("#txtRuc").val(datosJSON.datos.ruc_proveedor);
                $("#txtRazonSocial").val(datosJSON.datos.razon_social);
                $("#txtDireccion").val(datosJSON.datos.direccion);
                $("#txtTelefono").val(datosJSON.datos.telefono);
                $("#txtRepresentanteLegal").val(datosJSON.datos.representante_legal);

                
               $("#titulomodal").html("Editar datos de producto");
                
            }else{
              swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
           var datosJSON = $.parseJSON( error.responseText );
           swal("Ocurrió un error", datosJSON.mensaje , "error");
        });
}
