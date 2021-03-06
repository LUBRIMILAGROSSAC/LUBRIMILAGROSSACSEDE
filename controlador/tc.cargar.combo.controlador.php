<?php

require_once '../logica/TipoComprobante.class.php';
require_once '../util/funciones/Funciones.class.php';

try {
    $objTipo = new TipoComprobante();
    $resultado = $objTipo->cargarTipoComprobante();
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
