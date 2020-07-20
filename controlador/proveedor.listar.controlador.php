<?php

require_once '../logica/Proveedor.class.php';
require_once '../util/funciones/Funciones.class.php';

try {
    $objProveedor = new Proveedor();
    $resultado = $objProveedor->listar();
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
