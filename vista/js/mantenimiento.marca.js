//JQuery

$(document).ready(function(){
    //alert("Se esta ejecutando código en JS");
    listar();
   // cargarComboLinea("#cboLinea", "s");
    //cargarComboMarca("#cboMarca", "m");
    
});


function listar(){
    $.post
    (
        "../controlador/marca.listar.controlador.php"
    ).done(function(resultado){
        var datosJSON = resultado;
        if (datosJSON.estado === 200){ //Validamos si el controlador se ha ejecutado correctamente
            var html = "";
            html += '<small>';
            html += '<div class="table-responsive">';
            html += '<table id="tabla-listado" class="table table-bordered  table-bordered table-hover">';
            html += '<thead>';
            html += '<tr class = "danger" style="background-color: #ededed; height:25px; ">';
            html += '<th>NUM</th>';
            html += '<th>DESCRIPCION</th>';
 	    html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            
            //Detalle
            $.each(datosJSON.datos, function(i,item) {
                html += '<tr>';
                html += '<td align="center">'+item.codigo_marca+'</td>';
                html += '<td>'+item.descripcion+'</td>';
 		html += '<td align="center">';
		html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.codigo_marca + ')"><i class="fa fa-pencil"></i></button>';
		html += '&nbsp;&nbsp;';
		html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.codigo_marca + ')"><i class="fa fa-close"></i></button>';
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


function eliminar(codigo_marca){
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
                "../controlador/marca.eliminar.controlador.php",
                {
                    m_cod_marca: codigo_marca
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
    $("#titulomodal").html("Agregar una nueva marca");
    $("#txtCodigo").val("");
    $("#txtDescripcion").val("");
});


$("#myModal").on("shown.bs.modal", function(){
    $("#txtDescripcion").focus();
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
            var v_descripcion=$("#txtDescripcion").val();

           $.post
                (
                    "../controlador/marca.agregar.editar.controlador.php",
                    {
                        m_cod_marca:v_cod_pro,
                        m_descripcion:v_descripcion,
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
function leerDatos(codigo_marca) {
    //alert(codigo_producto);
    $.post
        (
            "../controlador/marca.leer.datos.controlador.php",
            {
                 m_cod_marca: codigo_marca
            }
        ).done(function(resultado){
            var datosJSON = resultado;

            if (datosJSON.estado === 200){
                $("#txtTipoOperacion").val("editar");
                $("#txtCodigo").val(datosJSON.datos.codigo_marca);
                $("#txtDescripcion").val(datosJSON.datos.descripcion);
                
               $("#titulomodal").html("Editar datos de producto");
                
            }else{
              swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
           var datosJSON = $.parseJSON( error.responseText );
           swal("Ocurrió un error", datosJSON.mensaje , "error");
        });
}
