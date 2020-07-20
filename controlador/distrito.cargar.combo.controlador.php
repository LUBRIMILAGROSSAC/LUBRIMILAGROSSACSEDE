<?php

//require_once '../logica/Categoria.class.php';
require_once '../logica/Distrito.class.php';
require_once '../util/funciones/Funciones.class.php';

try {
    $objDistrito = new Distrito();
    $resultado = $objDistrito->cargarDatosDistrito();
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
