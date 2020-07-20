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
    $resultado = $objProveedor->leerDatos($cod_pro);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
