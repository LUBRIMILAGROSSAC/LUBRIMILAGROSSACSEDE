<?php

require_once '../datos/Conexion.class.php';

class Marca extends Conexion {
    public $codigoMarca;
    public $descripcion;
    function getCodigoMarca() {
        return $this->codigoMarca;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setCodigoMarca($codigoMarca) {
        $this->codigoMarca = $codigoMarca;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

     
    public function cargarDatosMarca() {
        try {
            $sql = "
                    select
                            *
                    from
                            marca
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
    public function listar() {
        try {
            $sql = "SELECT 
                    codigo_marca, 
                    descripcion 
                    
              FROM 
                    marca;";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function eliminar($c_codigo_marca) {
        /* validar si el producto tiene pedidos */
        $sql = "
            select
                    codigo_marca
            from
                    producto
            where
                    codigo_marca = :m_codigo_marca
            ";

        $sentencia = $this->dbLink->prepare($sql);
        $sentencia->bindParam(":m_codigo_marca", $c_codigo_marca);
        $sentencia->execute();

        if ($sentencia->rowcount()) {
            throw new Exception("No es posible eliminar este producto por motivo de que tiene pedidos registrados");
        }

        /* validar si el producto tiene pedidos */




        /* Iniciar la transacción */
        $this->dbLink->beginTransaction();
        /* Iniciar la transacción */

        try {
            /* Elaborar la consulta SQL para eliminar el registro */
            $sql = "delete from marca  
                where codigo_marca = :m_codigo_marca";

            //Declarar una setencia en base a la consulta SQL
            $sentencia = $this->dbLink->prepare($sql);

            //Enviar los valores a los parámetros de la sentencia
            $sentencia->bindParam(":m_codigo_marca", $c_codigo_marca);

            //Ejecutar la sentencia
            $sentencia->execute();

            //Si todo lo anterior se ha ejecutado correctamente, entonces se confirma la transacción
            $this->dbLink->commit();

            //Si retorna "TRUE", significa que la transacciòn ha sido exitosa
            return true;
        } catch (Exception $exc) {
            //Abortamos la transacción
            $this->dbLink->rollBack();

            //Lanzar el error hacia la siguiente capa (controlador)
            throw $exc;
        }
    }

    public function agregar() {
        $this->dbLink->beginTransaction();

        try {
            /* Generar el correlativo del código del prodcucto a registrar */
            $sql = "select * from f_generar_correlativo('marca') as correlativo";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();

            if ($sentencia->rowCount()) {
                //Si se encontró el correlativo para la tabla producto
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
                $nuevoCodigoMarca = $resultado["correlativo"];
                $this->setCodigoMarca($nuevoCodigoMarca);

                /* Insertar en la tabla producto */
                $sql = "INSERT INTO 
	marca
		(
		codigo_marca, 
		descripcion
                
		)
    VALUES 
		(
		:m_codigo_marca, 
                :m_descripcion
		)";

                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->bindParam(":m_codigo_marca", $this->getCodigoMarca());
                $sentencia->bindParam(":m_descripcion", $this->getDescripcion());
                
                $sentencia->execute();

                /* Actualizar el correlativo para la tabla producto en + 1 */
                $sql = "update correlativo set numero = numero + 1 where tabla = 'marca'";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->execute();

                //Confirmar la transacción
                $this->dbLink->commit();

                return TRUE; //retorna verdadero cuando ha registrado todo correctamente
            } else {
                //No se encontró el correlativo para la tabla producto
                throw new Exception("No se encontró el correlativo para la tabla categoria");
            }
        } catch (Exception $exc) {
            $this->dbLink->rollBack(); //Abortar/Deshacer todo lo que se ha registrado dentro de la transacción
            throw $exc;
        }
    }

    public function leerDatos($m_codigo_marca) {
        try {
            $sql = "SELECT 
                    codigo_marca, 
                    descripcion
              FROM 
                    marca
            WHERE 
                    codigo_marca = :c_codigo_marca ;";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":c_codigo_marca", $m_codigo_marca);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function editar() {
        $this->dbLink->beginTransaction();

        try {
            $sql = "UPDATE 
                    marca
               SET 

                    descripcion			=:m_descripcion 
               
              
             WHERE 
                    codigo_marca = :m_codigo_marca;";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":m_descripcion", $this->getDescripcion());
            $sentencia->bindParam(":m_codigo_marca", $this->getCodigoMarca());
      
            $sentencia->execute();

            $this->dbLink->commit();

            return TRUE; //El producto se actualizó correctamente
        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
    }
    
}
