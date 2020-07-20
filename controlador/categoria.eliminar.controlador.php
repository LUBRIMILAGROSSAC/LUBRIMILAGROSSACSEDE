<?php

require_once '../logica/Categoria.class.php';
require_once '../util/funciones/Funciones.class.php';

try {
    if 
    (
        ! isset($_POST["c_cod_categoria"]) || 
            empty($_POST["c_cod_categoria"])

    )
    {
        Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
        exit; //Se detiene la aplicación
    }
    
    $cod_categoria = $_POST["c_cod_categoria"];
    
    $objCategoria = new Categoria();
    $respuesta = $objCategoria->eliminar($cod_categoria);
    
    if ($respuesta){ //Pregunto si la respuesta es TRUE
        Funciones::imprimeJSON(200, "El registro se ha eliminado correctamente", "");
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
