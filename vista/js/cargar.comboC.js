function cargarComboDistrito(p_nombreComb, p_tipo){
    $.post
    (
	"../controlador/distrito.cargar.combo.controlador.php"
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="d"){
                html += '<option value="">Seleccione una distrito</option>';
            }else{
                html += '<option value="0">Todas los distrito</option>';
            }

            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_distrito+'">'+item.nombre+'</option>';
            });
            
            $(p_nombreComb).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON(error.responseText);
	swal("Error", datosJSON.mensaje , "error");
    });
}