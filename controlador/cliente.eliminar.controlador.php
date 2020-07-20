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
        Funciones::imprimeJSON(500, "Falta completar datos requeridos Hola", "");
        exit; //Se detiene la aplicación
    }
    
    $cod_cli = $_POST["p_cod_cli"];
    
    $objCliente = new Cliente();
    $respuesta = $objCliente->eliminar($cod_cli);
    
    if ($respuesta){ //Pregunto si la respuesta es TRUE
        Funciones::imprimeJSON(200, "El registro se ha eliminado correctamente", "");
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
