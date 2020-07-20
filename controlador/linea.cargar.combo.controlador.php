<?php

//require_once '../logica/Categoria.class.php';
require_once '../logica/Linea.class.php';
require_once '../util/funciones/Funciones.class.php';

try {
    $objLinea = new Linea();
    $resultado = $objLinea->cargarDatosLinea();
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
