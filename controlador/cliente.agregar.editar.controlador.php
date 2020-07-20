<?php

require_once '../logica/Cliente.class.php';
require_once '../util/funciones/Funciones.class.php';

try {
    
    /*Validar si estan llegando todos los datos necesarios para grabar (agregar/editar)*/
    if 
    (
        ! isset($_POST["p_cod_cli"]) || 
        empty($_POST["p_cod_cli"])  ||
            
        ! isset($_POST["p_apellidos"]) || 
        empty($_POST["p_apellidos"])  ||
            
            ! isset($_POST["p_nombres"]) || 
        empty($_POST["p_nombres"])  ||
            
            ! isset($_POST["p_nro_doc_ide"]) || 
        empty($_POST["p_nro_doc_ide"])  ||
            
            ! isset($_POST["p_direccion"]) || 
        empty($_POST["p_direccion"])  ||
            
            ! isset($_POST["p_telefono_fijo"]) || 
        empty($_POST["p_telefono_fijo"])  ||
            
        ! isset($_POST["p_email"]) || 
        empty($_POST["p_email"])  ||
        
        ! isset($_POST["p_direccion_web"]) || 
        empty($_POST["p_direccion_web"])  ||
        
        
        ! isset($_POST["p_tip_doc_ide"]) || 
        empty($_POST["p_tip_doc_ide"])  ||
        
        ! isset($_POST["p_codigo_distrito"]) || 
        empty($_POST["p_codigo_distrito"]) 
        
    )
    {
        Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
        exit; //Se detiene la aplicación
        
    }
    
    /*Capturar los datos que llegan por la variable $_POST*/
    $codCli             = $_POST["p_cod_cli"];
    $apellidos          = $_POST["p_apellidos"];
    $nombres            = $_POST["p_nombres"];
    $dni                = $_POST["p_nro_doc_ide"];
    $direccion          = $_POST["p_direccion"];
    $telefono           = $_POST["p_telefono_fijo"];
    $correo             = $_POST["p_email"];
    $direccionweb       = $_POST["p_direccion_web"];
    $tipodocumento      = $_POST["p_tip_doc_ide"];
    $codigodistrito     = $_POST["p_codigo_distrito"];
    
    /*El tipo de operación permite saber si estamos insertando (agregando) o actualizando (editando)*/
    $tipoOperacion      = $_POST["p_tipo_operacion"]; 
    
    /*Instanciar la clase producto*/
    $objCliente = new Cliente();
    
    /*Envíar los datos recibidos del formulario hacia la clase*/
    $objCliente->setCodigoCliente($codCli);
    $objCliente->setApellidos($apellidos);
    $objCliente->setNombres($nombres);
    $objCliente->setDni($dni);
    $objCliente->setDireccion($direccion);
    $objCliente->setTelefono($telefono);
    $objCliente->setEmail($correo);
    $objCliente->setDireccionWeb($direccionweb);
    $objCliente->setTipoDocumento($tipodocumento);
    $objCliente->setCodigoDistrito($codigodistrito);
    
    /*Preguntar por el tipo de operación*/
    if ($tipoOperacion=="agregar"){
        $respuesta = $objCliente->agregar();
        if ($respuesta == TRUE){
            Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
        }
    }else{
        //Aqui se tiene que llamar al método editar
        $respuesta = $objCliente->editar();
        if ($respuesta == TRUE){
            Funciones::imprimeJSON(200, "Se ha actualizado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
