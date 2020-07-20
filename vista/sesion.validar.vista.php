<?php

require_once '../util/funciones/Funciones.class.php';

session_name("programacionII");
session_start();

/*
 * Validamos si el usuario ha iniciado sesión. 
 * 
 * En el caso de que no haya iniciado sesión, se mostrará 
 * un error y despues será redireccionado a la pàgina index.html
 */

if ( ! isset($_SESSION["nombre"])){
    Funciones::mensaje("No has iniciado sesión", "e", "index.html", 5);
    exit;
}

/*Leer los datos almacenados en la sesión*/
$sesion_nombre_usuario = ucwords(strtolower($_SESSION["nombre"]));
$sesion_cargo_usuario = ucwords(strtolower($_SESSION["cargo"]));
$sesion_email_usuario = $_SESSION["email"];
$sesion_dni_usuario = $_SESSION["dni"];

/*Validar si existe la foto con el DNI del usuario*/
$foto = $sesion_dni_usuario;

if (file_exists("../fotos/" . $foto . ".jpg" )){
    $foto = "../fotos/" . $foto . ".jpg";
    
}else if (file_exists("../fotos/" . $foto . ".png" )){
    $foto = "../fotos/" . $foto . ".png";
    
}else{
    $foto = "../fotos/default.jpg";
}

        



