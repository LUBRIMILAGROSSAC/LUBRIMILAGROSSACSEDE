<?php

require_once '../logica/Producto.class.php';
require_once '../util/funciones/Funciones.class.php';

try {
    
    /*Validar si estan llegando todos los datos necesarios para grabar (agregar/editar)*/
    if 
    (
        ! isset($_POST["p_cod_pr"]) || 
        empty($_POST["p_cod_pr"])  ||
            
        ! isset($_POST["p_nombre"]) || 
        empty($_POST["p_nombre"])  ||
            
        ! isset($_POST["p_precio_venta"]) || 
        empty($_POST["p_precio_venta"])  ||
            
        ! isset($_POST["p_tipo_producto"]) || 
        empty($_POST["p_tipo_producto"]) ||
         
        ! isset($_POST["p_stock"]) || 
        empty($_POST["p_stock"]) ||  
        
        ! isset($_POST["p_codigo_categoria"]) || 
        empty($_POST["p_codigo_categoria"])|| 
            
        ! isset($_POST["p_codigo_marca"]) || 
        empty($_POST["p_codigo_marca"])||
                ! isset($_POST["p_ubicacion"]) || 
        empty($_POST["p_ubicacion"])
    
        
       
        
    )
    {
        Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
        exit; //Se detiene la aplicación
    }
    
    /*Capturar los datos que llegan por la variable $_POST*/
    $codPro             = $_POST["p_cod_pr"];
    $nombre             = $_POST["p_nombre"];
    $precioVenta        = $_POST["p_precio_venta"];
    $tipoProducto       = $_POST["p_tipo_producto"];
    $stock              = $_POST["p_stock"];
    $categoria          = $_POST["p_codigo_categoria"];
    $marca              = $_POST["p_codigo_marca"];
    $ubicacion          = $_POST["p_ubicacion"];
    
    
    
    /*El tipo de operación permite saber si estamos insertando (agregando) o actualizando (editando)*/
    $tipoOperacion      = $_POST["p_tipo_operacion"]; 
    
    /*Instanciar la clase producto*/
    $objProducto = new Producto();
    
    /*Envíar los datos recibidos del formulario hacia la clase*/
    $objProducto->setCodigoProducto($codPro);
    $objProducto->setNombre($nombre);
    $objProducto->setPrecioVenta($precioVenta);
    $objProducto->setTipo_producto($tipoProducto);
    $objProducto->setStock($stock);
    $objProducto->setCodigoCategoria($categoria);
    $objProducto->setCodigoMarca($marca);
    $objProducto->setUbicacion($ubicacion);
    
    
    /*Preguntar por el tipo de operación*/
    if ($tipoOperacion=="agregar"){
        $respuesta = $objProducto->agregar();
        if ($respuesta == TRUE){
            Funciones::imprimeJSON(200, "Se ha agregado correctamente", "");
        }
    }else{
        //Aqui se tiene que llamar al método editar
        $respuesta = $objProducto->editar();
        if ($respuesta == TRUE){
            Funciones::imprimeJSON(200, "Se ha actualizado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
