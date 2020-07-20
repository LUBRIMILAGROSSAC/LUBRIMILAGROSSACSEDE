<?php

require_once '../datos/Conexion.class.php';

class Cliente extends Conexion {

    private $codigoCliente;
    private $apellidos;
    private $nombres;
    private $dni;
    private $direccion;
    private $telefono;
    private $email;
    private $direccionWeb;
    private $tipoDocumento;
    private $codigoDistrito;
    function getCodigoCliente() {
        return $this->codigoCliente;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getDni() {
        return $this->dni;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getEmail() {
        return $this->email;
    }

    function getDireccionWeb() {
        return $this->direccionWeb;
    }

    function getTipoDocumento() {
        return $this->tipoDocumento;
    }

    function getCodigoDistrito() {
        return $this->codigoDistrito;
    }

    function setCodigoCliente($codigoCliente) {
        $this->codigoCliente = $codigoCliente;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setDni($dni) {
        $this->dni = $dni;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setDireccionWeb($direccionWeb) {
        $this->direccionWeb = $direccionWeb;
    }

    function setTipoDocumento($tipoDocumento) {
        $this->tipoDocumento = $tipoDocumento;
    }

    function setCodigoDistrito($codigoDistrito) {
        $this->codigoDistrito = $codigoDistrito;
    }

        
    public function listar() {
        try {
            $sql = "
                select
                    c.codigo_cliente,
                    c.apellidos,
                    c.nombres,
                    c.nro_doc_ide,
                    c.direccion,
                    c.telefono_fijo,
                    c.email,
                    c.direccion_web,
                    c.tip_doc_ide,
                    d.nombre as distrito
                    

                from
                    cliente c
                  inner join distrito d on ( d.codigo_distrito = c.codigo_distrito )

                order by
                        c.nombres

                ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function eliminar($p_codigo_cliente) {
        /* validar si el producto tiene pedidos */
      





        /* Iniciar la transacción */
        $this->dbLink->beginTransaction();
        /* Iniciar la transacción */

        try {
            /* Elaborar la consulta SQL para eliminar el registro */
            $sql = "
                delete from cliente  
                where codigo_cliente = :p_cod_cli
                ";

            //Declarar una setencia en base a la consulta SQL
            $sentencia = $this->dbLink->prepare($sql);

            //Enviar los valores a los parámetros de la sentencia
            $sentencia->bindParam(":p_cod_cli", $p_codigo_cliente);

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
           
            $sql = "select * from f_generar_correlativo('cliente') as correlativo";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();

            if ($sentencia->rowCount()) {
            
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
                $nuevoCodigoCliente = $resultado["correlativo"];
                $this->setCodigoCliente($nuevoCodigoCliente);

             
                $sql = "
                        INSERT INTO cliente
                        (
                    codigo_cliente,
                    apellidos,
                    nombres,
                    nro_doc_ide,
                    direccion,
                    telefono_fijo,
                    email,
                    direccion_web,
                    tip_doc_ide,
                    codigo_distrito
                        )
                        VALUES 
                        (
                                :p_codigo_cliente, 
                                :p_apellidos, 
                                :p_nombres, 
                                :p_nro_doc_ide, 
                                :p_direccion, 
                                :p_telefono_fijo, 
                                :p_email, 
                                :p_direccion_web, 
                                :p_tip_doc_ide, 
                                :p_codigo_distrito
                        );
                    ";

                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_codigo_cliente", $this->getCodigoCliente());
                $sentencia->bindParam(":p_apellidos", $this->getApellidos());
                $sentencia->bindParam(":p_nombres", $this->getNombres());
                $sentencia->bindParam(":p_nro_doc_ide", $this->getDni());
                $sentencia->bindParam(":p_direccion", $this->getDireccion());
                $sentencia->bindParam(":p_telefono_fijo", $this->getTelefono());
                $sentencia->bindParam(":p_email", $this->getEmail());
                $sentencia->bindParam(":p_direccion_web", $this->getDireccionWeb());
                $sentencia->bindParam(":p_tip_doc_ide", $this->getTipoDocumento());
                $sentencia->bindParam(":p_codigo_distrito", $this->getCodigoDistrito());
                $sentencia->execute();

         
                $sql = "update correlativo set numero = numero + 1 where tabla = 'cliente'";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->execute();


                //Confirmar la transacción
                $this->dbLink->commit();

                return TRUE; //retorna verdadero cuando ha registrado todo correctamente
            } else {
                //No se encontró el correlativo para la tabla producto
                throw new Exception("No se encontró el correlativo para la tabla cliente");
            }
        } catch (Exception $exc) {
            $this->dbLink->rollBack(); //Abortar/Deshacer todo lo que se ha registrado dentro de la transacción
            throw $exc;
        }
    }

    public function leerDatos($p_codigo_cliente) {
        try {
            $sql = "
                select
                    codigo_cliente,
                    apellidos,
                    nombres,
                    nro_doc_ide,
                    direccion,
                    telefono_fijo,
                    email,
                    direccion_web,
                    tip_doc_ide,
                    codigo_distrito
                from
                    cliente
                where
                    codigo_cliente = :p_codigo_cliente
                ";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_codigo_cliente", $p_codigo_cliente);
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
            $sql = "
                    UPDATE 
                            cliente
                    SET 
                    apellidos          = :p_apellidos,
                    nombres            = :p_nombres,
                    nro_doc_ide        = :p_nro_doc_ide,
                    direccion          = :P_direccion,
                    telefono_fijo      = :P_telefono_fijo,
                    email              = :P_email,
                    direccion_web      = :P_direccion_web,
                    tip_doc_ide        = :P_tip_doc_ide,
                    codigo_distrito    = :P_codigo_distrito

                     WHERE
                            codigo_cliente 	= :p_codigo_cliente

                ";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_apellidos", $this->getApellidos());
            $sentencia->bindParam(":p_nombres", $this->getNombres());
            $sentencia->bindParam(":p_nro_doc_ide", $this->getDni());
            $sentencia->bindParam(":P_direccion", $this->getDireccion());
            $sentencia->bindParam(":P_telefono_fijo", $this->getTelefono());
            $sentencia->bindParam(":P_email", $this->getEmail());
            $sentencia->bindParam(":P_direccion_web", $this->getDireccionWeb());
            $sentencia->bindParam(":P_tip_doc_ide", $this->getTipoDocumento());
            $sentencia->bindParam(":P_codigo_distrito", $this->getCodigoDistrito());
            $sentencia->bindParam(":p_codigo_cliente", $this->getCodigoCliente());
            
            $sentencia->execute();

            $this->dbLink->commit();

            return TRUE; //El producto se actualizó correctamente
        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
    }

}
