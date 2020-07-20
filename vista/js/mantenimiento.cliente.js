//JQuery

$(document).ready(function(){
    //alert("Se esta ejecutando código en JS");
    listar();
    cargarComboDistrito("#cboDistrito", "d");
});


function listar(){
    $.post
    (
        "../controlador/cliente.listar.controlador.php"
    ).done(function(resultado){
        var datosJSON = resultado;
        if (datosJSON.estado === 200){ //Validamos si el controlador se ha ejecutado correctamente
            var html = "";
            html += '<small>';
            html += '<div class="table-responsive">';
            html += '<table id="tabla-listado" class="table table-bordered  table-bordered table-hover">';
            html += '<thead>';
            html += '<tr class = "info" style="background-color: #ededed; height:25px; ">';
            html += '<th>C.CLIEN</th>';
            html += '<th>APELLIDOS</th>';
            html += '<th>NOMBRES</th>';
            html += '<th>DNI</th>';
            html += '<th>DIRECCION</th>';
            html += '<th>TELEFONO</th>';
            html += '<th>EMAIL</th>';
            html += '<th>DIRECC.WEB</th>';
            html += '<th>TIPO.DOC</th>';
            html += '<th>DISTRITO</th>';
	    html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            
            //Detalle
            $.each(datosJSON.datos, function(i,item) {
                html += '<tr>';
                html += '<td align="center">'+item.codigo_cliente+'</td>';
                html += '<td>'+item.apellidos+'</td>';
                html += '<td>'+item.nombres+'</td>';
                html += '<td>'+item.nro_doc_ide+'</td>';
                html += '<td>'+item.direccion+'</td>';
                html += '<td>'+item.telefono_fijo+'</td>';
                html += '<td>'+item.email+'</td>';
                html += '<td>'+item.direccion_web+'</td>';
                html += '<td>'+item.tip_doc_ide+'</td>';
                html += '<td>'+item.distrito+'</td>';
		html += '<td align="center">';
		html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.codigo_cliente + ')"><i class="fa fa-pencil"></i></button>';
		html += '&nbsp;&nbsp;';
		html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.codigo_cliente + ')"><i class="fa fa-close"></i></button>';
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


function eliminar(codigo_cliente){
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
                "../controlador/cliente.eliminar.controlador.php",
                {
                    p_cod_cli: codigo_cliente
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
    $("#titulomodal").html("Agregar un nuevo Cliente");
    $("#txtCodigo").val("");
    $("#txtApellidos").val("");
    $("#txtNombres").val("");
    $("#txtDni").val("");
    $("#txtDireccion").val("");
    $("#txtTelefonoFijo").val("");
    $("#txtEmail").val("");
    $("#txtDireccionWeb").val("");
    $("#cboDistrito").val("");
    
});


$("#myModal").on("shown.bs.modal", function(){
    $("#txtApellidos").focus();
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
            var v_cod_cli = "";
            
            if (v_tipo_operacion==="agregar"){
                v_cod_cli = "nuevo";
            }else{
                v_cod_cli = $("#txtCodigo").val();
            }
            
            var v_apellidos = $("#txtApellidos").val();
            var v_nombres = $("#txtNombres").val();
            var v_dni = $("#txtDni").val();
            var v_direccion = $("#txtDireccion").val();
            var v_telefono = $("#txtTelefonoFijo").val();
            var v_email = $("#txtEmail").val();
            var v_direccionweb = $("#txtDireccionWeb").val();
            var v_tipodocumento = $("#cboTipoDocumento").val();
            var v_distrito = $("#cboDistrito").val();
            
            
            $.post
                (
                    "../controlador/cliente.agregar.editar.controlador.php",
                    {
                        p_cod_cli: v_cod_cli,
                        p_apellidos: v_apellidos,
                        p_nombres: v_nombres,
                        p_nro_doc_ide: v_dni,
                        p_direccion: v_direccion,
                        p_telefono_fijo: v_telefono,
                        p_email: v_email,
                        p_direccion_web: v_direccionweb,
                        p_tip_doc_ide: v_tipodocumento,
                        p_codigo_distrito: v_distrito,
                        p_tipo_operacion: v_tipo_operacion
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


function leerDatos(codigo_cliente){
    $.post
        (
            "../controlador/cliente.leer.datos.controlador.php",
            {
                p_cod_cli: codigo_cliente
            }
        ).done(function(resultado){
            var datosJSON = resultado;

            if (datosJSON.estado === 200){
                $("#txtTipoOperacion").val("editar");
                $("#txtCodigo").val(datosJSON.datos.codigo_cliente);
                $("#txtApellidos").val(datosJSON.datos.apellidos);
                $("#txtNombres").val(datosJSON.datos.nombres);
                $("#txtDni").val(datosJSON.datos.nro_doc_ide);
                $("#txtDireccion").val(datosJSON.datos.direccion);
                $("#txtTelefonoFijo").val(datosJSON.datos.telefono_fijo);
                $("#txtEmail").val(datosJSON.datos.email);
                $("#txtDireccionWeb").val(datosJSON.datos.direccion_web);
                $("#cboTipoDocumento").val(datosJSON.datos.tip_doc_ide);
                $("#cboDistrito").val(datosJSON.datos.codigo_distrito);
                $("#titulomodal").html("Editar datos de cliente");
            }else{
              swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
           var datosJSON = $.parseJSON( error.responseText );
           swal("Ocurrió un error", datosJSON.mensaje , "error");
        });
    
    
}



