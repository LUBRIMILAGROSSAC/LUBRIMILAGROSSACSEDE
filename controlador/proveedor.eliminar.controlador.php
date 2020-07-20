<?php

require_once '../logica/Proveedor.class.php';
require_once '../util/funciones/Funciones.class.php';

try {
    if 
    (
        ! isset($_POST["p_ruc_proveedor"]) || 
        empty($_POST["p_ruc_proveedor"])

    )
    {
        Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
        exit; //Se detiene la aplicación
    }
    
    $cod_pro = $_POST["p_ruc_proveedor"];
    
    $objProveedor = new Proveedor();
    $respuesta = $objProveedor->eliminar($cod_pro);
    
    if ($respuesta){ //Pregunto si la respuesta es TRUE
        Funciones::imprimeJSON(200, "El registro se ha eliminado correctamente", "");
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
