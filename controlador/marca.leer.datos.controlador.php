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
    $resultado = $objMarca->leerDatos($cod_marca);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
