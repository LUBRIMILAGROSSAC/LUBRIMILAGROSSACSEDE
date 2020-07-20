<?php

require_once '../logica/Marca.class.php';
require_once '../util/funciones/Funciones.class.php';

try {
    
    /*Validar si estan llegando todos los datos necesarios para grabar (agregar/editar)*/
    if 
    (
        !isset($_POST["m_cod_marca"])|| 
         empty($_POST["m_cod_marca"])||
            
        !isset($_POST["m_descripcion"])|| 
        empty($_POST["m_descripcion"])

        
    )
    {
        Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
        exit; //Se detiene la aplicación
    }
    
    /*Capturar los datos que llegan por la variable $_POST*/
    $codigoMarca             = $_POST["m_cod_marca"];
    $descripcion             = $_POST["m_descripcion"];

    
    
    
    /*El tipo de operación permite saber si estamos insertando (agregando) o actualizando (editando)*/
    $tipoOperacion      = $_POST["p_tipo_operacion"]; 
    
    /*Instanciar la clase producto*/
    $objMarca = new Marca();
    
    /*Envíar los datos recibidos del formulario hacia la clase*/
    $objMarca->setCodigoMarca($codigoMarca);
    $objMarca->setDescripcion($descripcion);

    
    
    /*Preguntar por el tipo de operación*/
    if ($tipoOperacion=="agregar"){
        $respuesta = $objMarca->agregar();
        if ($respuesta == TRUE){
            Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
        }
    }else{
        //Aqui se tiene que llamar al método editar
        $respuesta = $objMarca->editar();
        if ($respuesta == TRUE){
            Funciones::imprimeJSON(200, "Se ha actualizado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
