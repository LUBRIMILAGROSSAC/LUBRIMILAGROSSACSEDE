<?php

require_once '../logica/Cliente.class.php';
require_once '../util/funciones/Funciones.class.php';

try {
    if 
    (
        ! isset($_POST["p_cod_cli"]) || 
        empty($_POST["p_cod_cli"])
    )
    {
        Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
        exit; //Se detiene la aplicación
    }
    
    $cod_cli = $_POST["p_cod_cli"];
    
    $objCliente = new Cliente() ;
    $resultado = $objCliente->leerDatos($cod_cli);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
