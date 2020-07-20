<?php

require_once '../logica/Proveedor.class.php';
require_once '../util/funciones/Funciones.class.php';

try {
    
    /*Validar si estan llegando todos los datos necesarios para grabar (agregar/editar)*/
    if 
    (
        ! isset($_POST["p_ruc_proveedor"]) || 
        empty($_POST["p_ruc_proveedor"])  ||
            
        ! isset($_POST["p_razon_social"]) || 
        empty($_POST["p_razon_social"])  ||
            
        ! isset($_POST["p_direccion"]) || 
        empty($_POST["p_direccion"])  ||
            
        ! isset($_POST["p_telefono"]) || 
        empty($_POST["p_telefono"]) ||
        
        ! isset($_POST["p_representante_legal"]) || 
        empty($_POST["p_representante_legal"])
    
    )
    {
        Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
        exit; //Se detiene la aplicación
    }
    
    /*Capturar los datos que llegan por la variable $_POST*/
    $rucProve               = $_POST["p_ruc_proveedor"];
    $razonSocial            = $_POST["p_razon_social"];
    $direccion              = $_POST["p_direccion"];
    $telefono               = $_POST["p_telefono"];
    $representanteLegal     = $_POST["p_representante_legal"];

    
    
    /*El tipo de operación permite saber si estamos insertando (agregando) o actualizando (editando)*/
    $tipoOperacion      = $_POST["p_tipo_operacion"]; 
    
    /*Instanciar la clase producto*/
    $objProveedor = new Proveedor();
    
    /*Envíar los datos recibidos del formulario hacia la clase*/
    $objProveedor->setRucProveedor($rucProve);
    $objProveedor->setRazonSocial($razonSocial);
    $objProveedor->setDireccion($direccion);
    $objProveedor->setTelefono($telefono);
    $objProveedor->setRepresentanteLegal($representanteLegal);
    
    /*Preguntar por el tipo de operación*/
    if ($tipoOperacion=="agregar"){
        $respuesta = $objProveedor->agregar();
        if ($respuesta == TRUE){
            Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
        }
    }else{
        //Aqui se tiene que llamar al método editar
        $respuesta = $objProveedor->editar();
        if ($respuesta == TRUE){
            Funciones::imprimeJSON(200, "Se ha actualizado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
