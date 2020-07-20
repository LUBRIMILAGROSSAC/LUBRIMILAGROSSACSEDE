<?php

require_once '../logica/Compra.class.php';
require_once '../util/funciones/Funciones.class.php';
try {
    if 
    (
        ! isset($_POST["p_fecha1"]) || 
            empty($_POST["p_fecha1"])
    )
    {
        Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
        exit; //Se detiene la aplicación
    }
     $fecha1 = $_POST["p_fecha1"];
    $fecha2 = $_POST["p_fecha2"];
    $tipo   = $_POST["p_tipo"];
    
    $objCompra = new Compra();
    $resultado = $objCompra->listar($fecha1, $fecha2, $tipo);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


 /*if (! isset($_POST["p_fecha1"])){
	Funciones::imprimeJSON(500, "Faltan parametros", "");
	exit();
    }
    
        ! isset($_POST["fecha1"]) || 
        empty($_POST["fecha1"])||
    ! isset($_POST["fecha2"]) || 
        empty($_POST["fecha2"])||
    ! isset($_POST["$tipo"]) ||
        empty($_POST["$tipo"])
    //$fecha1 = $_POST["p_fecha1"];
    //$fecha2 = $_POST["p_fecha2"];
    //$tipo   = $_POST["p_tipo"];


    try {
        $objCompra = new Compra();
        $resultado = $objCompra->listar($fecha1, $fecha2, $tipo);
        Funciones::imprimeJSON(200, "", $resultado);
    } catch (Exception $exc) {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }
*/