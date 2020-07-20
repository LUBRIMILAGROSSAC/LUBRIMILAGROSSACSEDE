<?php

require_once '../datos/Conexion.class.php';

class Linea extends Conexion {
    public $codigoLinea;
    public $descripcion;

    
    public function cargarDatosLinea() {
        try {
            $sql = "
                    select
                            *
                    from
                            linea
                    order by
                            2
                ";
            
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
}
