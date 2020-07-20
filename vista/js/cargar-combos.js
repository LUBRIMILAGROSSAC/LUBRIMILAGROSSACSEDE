function cargarComboCategoria(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/categoria.cargar.combo.controlador.php"
    ).done(function(resultado){
	var datosJSON = $.parseJSON( JSON.stringify(resultado) );
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione una categoría</option>';
            }else{
                html += '<option value="0">Todas las categorías</option>';
            }

            
            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_categoria+'">'+item.descripcion+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}

function cargarComboMarca(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/marca.cargar.combo.controlador.php"
    ).done(function(resultado){
	var datosJSON = $.parseJSON( JSON.stringify(resultado) );
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione una marca</option>';
            }else{
                html += '<option value="0">Todas las marcas</option>';
            }

            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_marca+'">'+item.descripcion+'</option>';
            });
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}


function cargarComboTC(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/tc.cargar.combo.controlador.php"
    ).done(function(resultado){
	var datosJSON = $.parseJSON( JSON.stringify(resultado) );
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione un tipo de comprobante</option>';
            }else{
                html += '<option value="0">Todas los tipos de comprobante</option>';
            }

            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_tipo_comprobante+'">'+item.descripcion+'</option>';
            });
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}