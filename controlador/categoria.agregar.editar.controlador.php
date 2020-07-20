<?php

require_once '../logica/Categoria.class.php';
require_once '../util/funciones/Funciones.class.php';

try {
    
    /*Validar si estan llegando todos los datos necesarios para grabar (agregar/editar)*/
    if 
    (
        !isset($_POST["c_cod_categoria"])|| 
         empty($_POST["c_cod_categoria"])||
            
        !isset($_POST["c_descripcion"])|| 
        empty($_POST["c_descripcion"])||
            
        !isset($_POST["c_cod_linea"])|| 
         empty($_POST["c_cod_linea"])  

        
       
        
    )
    {
        Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
        exit; //Se detiene la aplicación
    }
    
    /*Capturar los datos que llegan por la variable $_POST*/
    $codigoCategoria             = $_POST["c_cod_categoria"];
    $descripcion                 = $_POST["c_descripcion"];
    $codigoLinea                 = $_POST["c_cod_linea"];

    
    
    
    /*El tipo de operación permite saber si estamos insertando (agregando) o actualizando (editando)*/
    $tipoOperacion      = $_POST["p_tipo_operacion"]; 
    
    /*Instanciar la clase producto*/
    $objCategoria = new Categoria();
    
    /*Envíar los datos recibidos del formulario hacia la clase*/
    $objCategoria->setCodigoCategoria($codigoCategoria);
    $objCategoria->setDescripcion($descripcion);
    $objCategoria->setCodigoLinea($codigoLinea);

    
    
    /*Preguntar por el tipo de operación*/
    if ($tipoOperacion=="agregar"){
        $respuesta = $objCategoria->agregar();
        if ($respuesta == TRUE){
            Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
        }
    }else{
        //Aqui se tiene que llamar al método editar
        $respuesta = $objCategoria->editar();
        if ($respuesta == TRUE){
            Funciones::imprimeJSON(200, "Se ha actualizado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
