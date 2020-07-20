<?php

require_once '../logica/Compra.class.php';
require_once '../util/funciones/Funciones.class.php';

parse_str($_POST["p_array_datos_cabecera"], $datosCabecera);
$datosDetalle = $_POST["p_json_datos_detalle"];

$objCompra = new Compra();
$objCompra->setCodigoTipoComprobante($datosCabecera["cbotipdoc"]);
$objCompra->setRucProveedor($datosCabecera["txtrucproveedor"]);
$objCompra->setNumeroSerie($datosCabecera["txtnroser"]);
$objCompra->setNumeroDocumento($datosCabecera["txtnrodoc"]);
$objCompra->setFechaCompra($datosCabecera["txtfec"]);
$objCompra->setPorcentajeIgv($datosCabecera["txtigv"]);
$objCompra->setSubTotal($datosCabecera["txtimportesubtotal"]);
$objCompra->setIgv($datosCabecera["txtimporteigv"]);
$objCompra->setTotal($datosCabecera["txtimporteneto"]);
$objCompra->setCodigoUsuario( $codigoUsuarioSesion );
$objCompra->setDetalle( $datosDetalle );

try {
    if ($objCompra->agregar()==true){
        Funciones::imprimeJSON(200, "Datos registrados correctamente", "");
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}