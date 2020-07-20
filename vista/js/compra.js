$(document).ready(function(){
    cargarComboTC("#cbotipdoc","seleccione");
    obtenerIGV();
});

function obtenerIGV(){
    $.post(
            "../controlador/configuracion.controlador.php",
            {
                p_codigo: 1
            }
          ).done(function(resultado){
                var datosJSON = $.parseJSON( JSON.stringify(resultado) );

                if (datosJSON.estado===200){
                    $("#txtigv").val(datosJSON.datos);
                }else{
                    swal("Mensaje del sistema", resultado , "warning");
                }
              
          });
}

$("#btnagregar").click(function(){
    
    if ( $("#txtcodigoarticulo").val().toString() === "" ){
        //alert("Debe seleccionar un artículo");
        swal("Verifique", "Debe seleccionar un artículo", "warning");
        $("#txtarticulo").val("");
        $("#txtprecio").val("");
        $("#txtcantidad").val("");
        $("#txtarticulo").focus();
        return 0; //detener el programa
    }

    var codigo   = $("#txtcodigoarticulo").val();
    var nombre   = $("#txtarticulo").val();
    var precio   = $("#txtprecio").val();
    var cantidad = $("#txtcantidad").val();
    var importe = precio * cantidad;

    var fila =   '<tr>'+
                     '<td>'+ codigo +'</td>'+
                     '<td>' + nombre + '</td>'+
                     '<td style="text-align: right">' + precio + '</td>'+
                     '<td style="text-align: right" id="ccantidad">' + cantidad + '</td>'+
                     '<td style="text-align: right">' + importe + "</td>"+
                     '<td align="center" id="celiminar"><a href="javascript:void();"><i class="fa fa-trash text-orange"></i></a></td>'+
                  '</tr>';

     $("#detallecompra").append(fila);
     

     $("#txtcodigoarticulo").val("");
     $("#txtarticulo").val("");
     $("#txtprecio").val("");
     $("#txtcantidad").val("");
     $("#txtarticulo").focus();
     
     calcularTotales();
   
});


function calcularTotales(){
    var importeSubTotal=0;
    var importeIGV=0;
    var importeNeto=0;

    $("#detallecompra tr").each(function(){
        var importe = $(this).find("td").eq(4).html();
        importeNeto = importeNeto + parseFloat(importe);
    });
    
    var porcentajeIGV = $("#txtigv").val();
    
    importeSubTotal = importeNeto / (1 + ( porcentajeIGV  /100));
    importeIGV = importeNeto - importeSubTotal;
    
    $("#txtimporteneto").val(importeNeto.toFixed(2));
    $("#txtimportesubtotal").val(importeSubTotal.toFixed(2));
    $("#txtimporteigv").val(importeIGV.toFixed(2));
    
}


$("#txtcantidad").keypress(function(evento){
    if (evento.which === 13){ //le pregunto si he pulsado la tecla ENTER
        evento.preventDefault(); //ignore el evento
        $("#btnagregar").click();
    }else{
	return validarNumeros(evento);
    }
});


$(document).on("click", "#celiminar", function(){
    var fila = $(this).parents().get(0); //capturar la fila que deseamos eliminar 
    
    swal({
		title: "Confirme",
		text: "¿Desea eliminar el registro seleccionado?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#ff0000',
		confirmButtonText: 'Si',
		cancelButtonText: "No",
		closeOnConfirm: true,
		closeOnCancel: true
	},
	function(isConfirm){ 

            if (isConfirm){ //el usuario hizo clic en el boton SI     
                fila.remove(); //eliminar la fila seleccionada
                calcularTotales();
                $("#txtarticulo").focus();
            }
	});   
});


$("#frmgrabar").submit(function(evento){
   evento.preventDefault();
   
   swal({
		title: "Confirme",
		text: "¿Esta seguro de grabar los datos ingresados?",
		
		showCancelButton: true,
		confirmButtonColor: '#3d9205',
		confirmButtonText: 'Si',
		cancelButtonText: "No",
		closeOnConfirm: false,
		closeOnCancel: true,
                imageUrl: "../imagenes/pregunta.png"
	},
	function(isConfirm){

            if (isConfirm){ //el usuario hizo clic en el boton SI     
                grabarCompra();
                //alert("grabar la compra");
            }
	}); 
   
    
});

var arrayDetalle = new Array(); //permite almacenar todos los articulos agregados en el detalle

function grabarCompra(){
    /*limpiar el array*/
    arrayDetalle.splice(0, arrayDetalle.length);
    /*limpiar el array*/
   
   /*CAPTURAR LOS DATOS PARA EL DETALLE DE COMPRA*/
   var item=0;
   $("#detallecompra tr").each(function(){
       var codigoArticulo = $(this).find("td").eq(0).html();
       item = item + 1;
       var cantidad = $(this).find("td").eq(3).html();
       var precio = $(this).find("td").eq(2).html();
       var importe = $(this).find("td").eq(4).html();
       
       var objDetalle = new Object(); //Crear un objeto para almacenar los datos
       /*declaramos y asignamos los valores a los atributos*/
       objDetalle.codigoArticulo = codigoArticulo;
       objDetalle.item      = item;
       objDetalle.cantidad  = cantidad;
       objDetalle.precio    = precio;
       objDetalle.importe   = importe;
       /*declaramos y asignamos los valores a los atributos*/
       
       arrayDetalle.push(objDetalle); //agregar el objeto objDetalle al array
       
   });
   
   //Convirtiendo el array a formato de JSON
   var jsonDetalle = JSON.stringify(arrayDetalle);
  
   /*CAPTURAR LOS DATOS PARA EL DETALLE DE COMPRA*/
   $.post(
           "../controlador/compra.grabar.controlador.php",
           {
               p_array_datos_cabecera: $("#frmgrabar").serialize(),
               p_json_datos_detalle: jsonDetalle
           }
        ).done(function(resultado){
            var datosJSON = $.parseJSON( JSON.stringify(resultado) );

            if (datosJSON.estado===200){
                swal({
                    title: "Exito",
                    text: datosJSON.mensaje,
                    type: "success",
                    showCancelButton: false,
                    //confirmButtonColor: '#3d9205',
                    confirmButtonText: 'Ok',
                    closeOnConfirm: true,
                },
                function(){
                    document.location.href="compra.listado.vista.php";
                });
            }else{
                swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
            var datosJSON = $.parseJSON( error.responseText );
            swal("Error", datosJSON.mensaje , "error");
        });
}