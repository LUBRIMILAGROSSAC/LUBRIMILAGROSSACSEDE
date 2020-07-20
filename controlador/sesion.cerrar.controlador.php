<?php

require_once '../util/funciones/Funciones.class.php';

session_name("programacionII");
session_start();

unset($_SESSION["nombre"]);
unset($_SESSION["cargo"]);
unset($_SESSION["email"]);
unset($_SESSION["dni"]);

session_destroy();

Funciones::mensaje("Su sesión se ha cerrado correctamente", "s", "../vista/index.html", 5);

