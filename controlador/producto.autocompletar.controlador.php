<?php
require_once '../util/funciones/Funciones.class.php';
require_once '../logica/Producto.class.php';

$valorBusqueda = $_GET["term"];

if (!$valorBusqueda){
    return;
}

$objProducto = new Producto();
try {
    $resultado = 
            $objProducto->buscarArticulo($valorBusqueda);
    
    $retorno = array();
    
    for ($i = 0; $i < count($resultado); $i++) {
        $datos = array
            (
                "label" => $resultado[$i]["nombre"],
                "value" => array(
                    "codigo"  => $resultado[$i]["codigo_producto"],
                    "nombre"  => $resultado[$i]["nombre"],
                    "preciov" => $resultado[$i]["precio_venta"],
                )
            );
        $retorno[$i] = $datos;
    }
    
    echo json_encode($retorno);
    
    
    
} catch (Exception $exc) {
    echo $exc->getMessage();
}

