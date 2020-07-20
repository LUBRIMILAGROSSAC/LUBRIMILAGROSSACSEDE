<?php

require_once '../logica/Producto.class.php';
require_once '../util/funciones/Funciones.class.php';

try {
    $objProducto = new Producto();
    $resultado = $objProducto->listar();
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
