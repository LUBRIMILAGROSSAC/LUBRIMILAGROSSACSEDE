<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
                require_once '../controlador/producto.listar.controlador.php';
                echo "<pre>";
                print_r($resultado);
                echo "</pre>";
        ?>
    </body>
</html>
