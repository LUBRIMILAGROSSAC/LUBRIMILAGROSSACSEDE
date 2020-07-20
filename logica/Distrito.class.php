<?php

require_once '../datos/Conexion.class.php';

class Distrito extends Conexion {
    
    public function cargarDatosDistrito() {
        try {
            $sql = "
                    select
                            *
                    from
                            distrito
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
