<?php

require_once '../logica/Compra.class.php';
require_once '../util/funciones/Funciones.class.php';

$nroCompra = $_POST["p_nro_compra"];
$objCompra = new Compra();

try {
    $objCompra->setNroCompra($nroCompra);
    if ($objCompra->anular()==true){
        Funciones::imprimeJSON(200, "Compra anulada correctamente", "");
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
