<?php

require_once '../datos/Conexion.class.php';

class Proveedor extends Conexion {
    private $rucProveedor;
    private $razonSocial;
    private $direccion;
    private $telefono;
    private $representanteLegal;
    function getRucProveedor() {
        return $this->rucProveedor;
    }

    function getRazonSocial() {
        return $this->razonSocial;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getRepresentanteLegal() {
        return $this->representanteLegal;
    }

    function setRucProveedor($rucProveedor) {
        $this->rucProveedor = $rucProveedor;
    }

    function setRazonSocial($razonSocial) {
        $this->razonSocial = $razonSocial;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setRepresentanteLegal($representanteLegal) {
        $this->representanteLegal = $representanteLegal;
    }

    public function listar() {
        try {
            $sql = "SELECT 
                        ruc_proveedor, 
                        razon_social, 
                        direccion, 
                        telefono, 
                        representante_legal
                  FROM 
                        proveedor;";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function eliminar($p_ruc_proveedor) {
     

        /* validar si el producto tiene pedidos */




        /* Iniciar la transacción */
        $this->dbLink->beginTransaction();
        /* Iniciar la transacción */

        try {
            /* Elaborar la consulta SQL para eliminar el registro */
            $sql = "
                delete from proveedor  
                where ruc_proveedor = :p_ruc_proveedor
                ";

            //Declarar una setencia en base a la consulta SQL
            $sentencia = $this->dbLink->prepare($sql);

            //Enviar los valores a los parámetros de la sentencia
            $sentencia->bindParam(":p_ruc_proveedor", $p_ruc_proveedor);

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
        //$this->dbLink->beginTransaction();
        $this->dbLink->beginTransaction();

        try {

                /* Insertar en la tabla producto */
                $sql = "INSERT INTO 
                    proveedor
                    (
                    ruc_proveedor, 
                    razon_social, 
                    direccion, 
                    telefono, 
                    representante_legal
                    )
                VALUES 
                    (
                    :p_ruc_proveedor, 
                    :p_razon_social, 
                    :p_direccion, 
                    :p_telefono, 
                    :p_representante_legal
                    );";

                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_ruc_proveedor", $this->getRucProveedor());
                $sentencia->bindParam(":p_razon_social", $this->getRazonSocial());
                $sentencia->bindParam(":p_direccion", $this->getDireccion());
                $sentencia->bindParam(":p_telefono", $this->getTelefono());
                $sentencia->bindParam(":p_representante_legal", $this->getRepresentanteLegal());
             
            $sentencia->execute();

            $this->dbLink->commit();

            return TRUE;  //El producto se actualizó correctamente
        } catch (Exception $exc) {
            $this->dbLink->rollBack(); //Abortar/Deshacer todo lo que se ha registrado dentro de la transacción
            throw $exc;
        }
    }

    public function leerDatos($p_ruc_proveedor) {
        try {
            $sql = "SELECT 
                        ruc_proveedor, 
                        razon_social, 
                        direccion, 
                        telefono, 
                        representante_legal
                    
                    
              FROM 
                    proveedor
            WHERE 
                    ruc_proveedor = :p_ruc_proveedor ;";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_ruc_proveedor", $p_ruc_proveedor);
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
                    proveedor
               SET 

                    razon_social			=:p_razon_social, 
                    direccion                           =:p_direccion,
                    telefono                            =:p_telefono,
                    representante_legal                 =:p_representante_legal
             WHERE 
                    ruc_proveedor = :p_ruc_proveedor;";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_razon_social", $this->getRazonSocial());
            $sentencia->bindParam(":p_direccion", $this->getDireccion());
            $sentencia->bindParam(":p_telefono", $this->getTelefono());
            $sentencia->bindParam(":p_representante_legal", $this->getRepresentanteLegal());
            $sentencia->bindParam(":p_ruc_proveedor", $this->getRucProveedor());
       
            $sentencia->execute();

            $this->dbLink->commit();

            return TRUE; //El producto se actualizó correctamente
        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
    }
  


        }
   

 
