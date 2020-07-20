<?php

require_once '../logica/Proveedor.class.php';
require_once '../util/funciones/Funciones.class.php';

$valorBusqueda = $_GET["term"];

if (!$valorBusqueda){
    return;
}

$objProveedor = new Proveedor();
try {
    $resultado = 
	    $objProveedor->obtenerProveedor($valorBusqueda);
    
    $retorno = array();
    
    for ($i = 0; $i < count($resultado); $i++) {
        $datos = array
            (
                "label" => $resultado[$i]["razon_social"],
                "value" => array(
                    "ruc" => $resultado[$i]["ruc_proveedor"],
                    "rs"  => $resultado[$i]["razon_social"],
                    "dir" => $resultado[$i]["direccion"],
                    "tel" => $resultado[$i]["telefono"]
                )
            );
        $retorno[$i] = $datos;
    }
    
//    echo '<pre>';
//    print_r($retorno);
//    echo '</pre>';
    
    echo json_encode($retorno);
    
    
    
} catch (Exception $exc) {
    echo $exc->getMessage();
}

