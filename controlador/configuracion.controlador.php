<?php
require_once '../util/funciones/Funciones.class.php';
require_once '../logica/Configuracion.class.php';

$codigoConfiguracion = $_POST["p_codigo"];

$objConf = new Configuracion();
try {
    $resultado = $objConf->obtenerValor($codigoConfiguracion);
    Funciones::imprimeJSON(200, "", $resultado["valor"]);
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}





