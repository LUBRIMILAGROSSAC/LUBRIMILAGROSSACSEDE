<?php

require_once '../datos/Conexion.class.php';

class Configuracion extends Conexion {
    
 public function obtenerValor($codigo) {
        try {
            $sql = "select valor from configuracion where codigo = :p_codigo";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_codigo", $codigo);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
}}
