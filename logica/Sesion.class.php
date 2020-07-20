<?php

require_once '../datos/Conexion.class.php';

class Sesion extends Conexion {
    private $email;
    private $clave;
    
    function getEmail() {
        return $this->email;
    }

    function getClave() {
        return $this->clave;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    public function iniciarSesion() {
        try {
            $sql="
                select
                        p.apellido_paterno,
                        p.apellido_materno,
                        p.nombres,
                        u.clave,
                        u.estado,
                        c.descripcion as cargo,
                        p.dni
                from
                        personal p
                        inner join usuario u on ( u.dni_usuario = p.dni )
                        inner join cargo c on ( c.codigo_cargo = p.codigo_cargo )
                where
                        p.email = :p_email
                ";
            
            //Declarar la sentencia
            $sentencia = $this->dbLink->prepare($sql);
            
            //Asignar el valor a los parametros de la sentencia
            $sentencia->bindParam(":p_email", $this->getEmail());
            
            //Ejecutar la sentencia
            $sentencia->execute();
            
            if ($sentencia->rowCount()){ //Le pregunto si la sentencia devuelve registros
                //El usuario si existe
                
                //Recoger el resultado que devuelve la sentencia
                $resultado = $sentencia->fetch();
                        
                //Validar si la contraseña ingresada por el usuario es la misma que esta registrada en la BD
                if ($resultado["clave"] == md5($this->getClave())){
                    //Validar el estado del usuario
                    if ($resultado["estado"] == "A"){
                        //El usuario esta activo
                        
                        //Crear la sesión
                        session_name("programacionII");
                        session_start();
                        $_SESSION["nombre"] = $resultado["nombres"] . " " . $resultado["apellido_paterno"];
                        $_SESSION["cargo"] = $resultado["cargo"];
                        $_SESSION["email"] = $this->getEmail();
                        $_SESSION["dni"] = $resultado["dni"];
                        
                        return "SI"; //Puede ingresar a la aplicación
                    }else{
                        return "UI"; //El usuario esta inactivo
                    }
                }else{
                    return "CI"; //Contraseña incorrecta
                }
                
            }else{
                return "NE"; //El usuario ingresado no existe
            }
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
}
