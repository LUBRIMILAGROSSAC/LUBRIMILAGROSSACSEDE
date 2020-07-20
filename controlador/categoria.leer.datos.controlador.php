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
    $resultado = $objCategoria->leerDatos($cod_categoria);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
