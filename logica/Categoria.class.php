<?php

require_once '../datos/Conexion.class.php';

class Categoria extends Conexion {
    public $codigoCategoria;
    public $descripcion;
    public $codigoLinea;
    function getCodigoCategoria() {
        return $this->codigoCategoria;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getCodigoLinea() {
        return $this->codigoLinea;
    }

    function setCodigoCategoria($codigoCategoria) {
        $this->codigoCategoria = $codigoCategoria;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setCodigoLinea($codigoLinea) {
        $this->codigoLinea = $codigoLinea;
    }

        public function cargarDatosCategoria() {
        try {
            $sql = "
                    select
                            *
                    from
                            categoria
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
                    c.codigo_categoria, 
                    c.descripcion as descripcion, 
                    l.descripcion as linea
              FROM 
                    categoria c
                    inner join linea l on 
                    c.codigo_linea=l.codigo_linea;";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function eliminar($c_codigo_categoria) {
        /* validar si el producto tiene pedidos */
        $sql = "
            select
                    codigo_categoria
            from
                    producto
            where
                    codigo_categoria = :c_codigo_categoria
            ";

        $sentencia = $this->dbLink->prepare($sql);
        $sentencia->bindParam(":c_codigo_categoria", $c_codigo_categoria);
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
            $sql = "delete from categoria  
                where codigo_categoria = :c_codigo_categoria";

            //Declarar una setencia en base a la consulta SQL
            $sentencia = $this->dbLink->prepare($sql);

            //Enviar los valores a los parámetros de la sentencia
            $sentencia->bindParam(":c_codigo_categoria", $c_codigo_categoria);

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
            $sql = "select * from f_generar_correlativo('categoria') as correlativo";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();

            if ($sentencia->rowCount()) {
                //Si se encontró el correlativo para la tabla producto
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
                $nuevoCodigoCategoria = $resultado["correlativo"];
                $this->setCodigoCategoria($nuevoCodigoCategoria);

                /* Insertar en la tabla producto */
                $sql = "INSERT INTO 
	categoria
		(
		codigo_categoria, 
		descripcion, 
		codigo_linea
                
		)
    VALUES 
		(
		:c_codigo_categoria, 
                :c_descripcion, 
                :c_codigo_linea
            
		);";

                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->bindParam(":c_codigo_categoria", $this->getCodigoCategoria());
                $sentencia->bindParam(":c_descripcion", $this->getDescripcion());
                $sentencia->bindParam(":c_codigo_linea", $this->getCodigoLinea());
    
                
                $sentencia->execute();

                /* Actualizar el correlativo para la tabla producto en + 1 */
                $sql = "update correlativo set numero = numero + 1 where tabla = 'categoria'";
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

    public function leerDatos($c_codigo_categoria) {
        try {
            $sql = "SELECT 
                    codigo_categoria, 
                    descripcion, 
                    codigo_linea
             
                    
                    
              FROM 
                    categoria
            WHERE 
                    codigo_categoria = :c_codigo_categoria ;";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":c_codigo_categoria", $c_codigo_categoria);
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
                    categoria
               SET 

                    descripcion			=:c_descripcion, 
                    codigo_linea		=:c_codigo_linea
                
              
             WHERE 
                    codigo_categoria = :c_codigo_caregoria;";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":c_descripcion", $this->getDescripcion());
            $sentencia->bindParam(":c_codigo_linea", $this->getCodigoLinea());
            $sentencia->bindParam(":c_codigo_caregoria", $this->getCodigoCategoria());
      
            $sentencia->execute();

            $this->dbLink->commit();

            return TRUE; //El producto se actualizó correctamente
        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
    }
    
}


