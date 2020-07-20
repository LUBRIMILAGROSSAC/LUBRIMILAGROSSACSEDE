<?php

require_once '../logica/Producto.class.php';
require_once '../util/funciones/Funciones.class.php';

try {
    if 
    (
        ! isset($_POST["p_cod_pr"]) || 
        empty($_POST["p_cod_pr"])
    )
    {
        Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
        exit; //Se detiene la aplicación
    }
    
    $cod_pro = $_POST["p_cod_pr"];
    
    $objProducto = new Producto();
    $resultado = $objProducto->leerDatos($cod_pro);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
