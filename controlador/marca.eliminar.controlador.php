<?php

require_once '../logica/Marca.class.php';
require_once '../util/funciones/Funciones.class.php';

try {
    if 
    (
        ! isset($_POST["m_cod_marca"]) || 
            empty($_POST["m_cod_marca"])

    )
    {
        Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
        exit; //Se detiene la aplicación
    }
    
    $cod_marca = $_POST["m_cod_marca"];
    
    $objMarca = new Marca();
    $respuesta = $objMarca->eliminar($cod_marca);
    
    if ($respuesta){ //Pregunto si la respuesta es TRUE
        Funciones::imprimeJSON(200, "El registro se ha eliminado correctamente", "");
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
