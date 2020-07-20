<?php

require_once '../datos/Conexion.class.php';

class Producto extends Conexion {

    private $codigoProducto;
    private $nombre;
    private $precioVenta;
    private $codigoCategoria;
    private $codigoMarca;
    private $stock;
    private $tipo_producto;
    private $ubicacion;
    function getCodigoProducto() {
        return $this->codigoProducto;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getPrecioVenta() {
        return $this->precioVenta;
    }

    function getCodigoCategoria() {
        return $this->codigoCategoria;
    }

    function getCodigoMarca() {
        return $this->codigoMarca;
    }

    function getStock() {
        return $this->stock;
    }

    function getTipo_producto() {
        return $this->tipo_producto;
    }

    function getUbicacion() {
        return $this->ubicacion;
    }

    function setCodigoProducto($codigoProducto) {
        $this->codigoProducto = $codigoProducto;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setPrecioVenta($precioVenta) {
        $this->precioVenta = $precioVenta;
    }

    function setCodigoCategoria($codigoCategoria) {
        $this->codigoCategoria = $codigoCategoria;
    }

    function setCodigoMarca($codigoMarca) {
        $this->codigoMarca = $codigoMarca;
    }

    function setStock($stock) {
        $this->stock = $stock;
    }

    function setTipo_producto($tipo_producto) {
        $this->tipo_producto = $tipo_producto;
    }

    function setUbicacion($ubicacion) {
        $this->ubicacion = $ubicacion;
    }

        public function listar() {
        try {
            $sql = " SELECT 
                            p.codigo_producto, 
                            p.nombre, 
                            case when cd.precio is null then 'PENDIENTE' else cd.precio::text end as precio_compra,
                            p.precio_venta,
                            p.tipo_producto, 
                            c.descripcion as categoria, 
                            l.descripcion as linea,
                            m.descripcion as marca,
                            p.stock, 
                            p.tipo_producto,
                            p.ubicacion
                      FROM 
                            producto p
                    inner join categoria c on ( p.codigo_categoria = c.codigo_categoria)
                    inner join linea l on ( l.codigo_linea = c.codigo_linea )
                    inner join marca m on ( m.codigo_marca = p.codigo_marca)
                    inner join compra_detalle cd on (cd.codigo_producto=p.codigo_producto)  
                            order by codigo_producto; ";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function eliminar($p_codigo_producto) {
        /* validar si el producto tiene pedidos */
        $sql = "
            select
                    codigo_producto
            from
                    compra_detalle
            where
                    codigo_producto = :p_cod_pro
            ";

        $sentencia = $this->dbLink->prepare($sql);
        $sentencia->bindParam(":p_cod_pro", $p_codigo_producto);
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
            $sql = "
                delete from producto  
                where codigo_producto = :p_cod_pro
                ";

            //Declarar una setencia en base a la consulta SQL
            $sentencia = $this->dbLink->prepare($sql);

            //Enviar los valores a los parámetros de la sentencia
            $sentencia->bindParam(":p_cod_pro", $p_codigo_producto);

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
            $sql = "select * from f_generar_correlativo('producto') as correlativo";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();

            if ($sentencia->rowCount()) {
                //Si se encontró el correlativo para la tabla producto
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
                $nuevoCodigoProducto = $resultado["correlativo"];
                $this->setCodigoProducto($nuevoCodigoProducto);

                /* Insertar en la tabla producto */
                $sql = "INSERT INTO 
	producto
		(
		codigo_producto, 
		nombre, 
		precio_venta,
                tipo_producto,
                stock,
		codigo_categoria, 
		codigo_marca,
		ubicacion
                
		)
    VALUES 
		(
		:p_codigo_producto, 
                :p_nombre, 
                :p_precio_venta,
                :p_tipo_producto,
                :p_stock,
                :p_codigo_categoria, 
                :p_codigo_marca,
                :p_ubicacion
		);";

                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_codigo_producto", $this->getCodigoProducto());
                $sentencia->bindParam(":p_nombre", $this->getNombre());
                $sentencia->bindParam(":p_precio_venta", $this->getPrecioVenta());
                $sentencia->bindParam(":p_tipo_producto", $this->getTipo_producto());
                $sentencia->bindParam(":p_stock", $this->getStock());
                $sentencia->bindParam(":p_codigo_categoria", $this->getCodigoCategoria());
                $sentencia->bindParam(":p_codigo_marca", $this->getCodigoMarca());
                $sentencia->bindParam(":p_ubicacion", $this->getUbicacion());
                
                $sentencia->execute();

                /* Actualizar el correlativo para la tabla producto en + 1 */
                $sql = "update correlativo set numero = numero + 1 where tabla = 'producto'";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->execute();


                //Confirmar la transacción
                $this->dbLink->commit();

                return TRUE; //retorna verdadero cuando ha registrado todo correctamente
            } else {
                //No se encontró el correlativo para la tabla producto
                throw new Exception("No se encontró el correlativo para la tabla producto");
            }
        } catch (Exception $exc) {
            $this->dbLink->rollBack(); //Abortar/Deshacer todo lo que se ha registrado dentro de la transacción
            throw $exc;
        }
    }

    public function leerDatos($p_codigo_producto) {
        try {
            $sql = "SELECT 
                    codigo_producto, 
                    nombre, 
                    precio_venta, 
                    tipo_producto,
                    stock,
                    codigo_categoria, 
                    codigo_marca,
                    ubicacion
                    
                    
              FROM 
                    producto
            WHERE 
                    codigo_producto = :p_codigo_producto ;";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_codigo_producto", $p_codigo_producto);
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
                    producto
               SET 

                    nombre			=:p_nombre, 
                    precio_venta		=:p_precio_venta,
                    tipo_producto		=:p_tipo_producto,
                    stock       		=:p_stock,
                    codigo_categoria            =:p_codigo_categoria,
                    codigo_marca		=:p_codigo_marca, 
                    ubicacion   		=:p_ubicacion 
                    
             WHERE 
                    codigo_producto = :p_codigo_producto;";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_nombre", $this->getNombre());
            $sentencia->bindParam(":p_precio_venta", $this->getPrecioVenta());
            $sentencia->bindParam(":p_tipo_producto", $this->getTipo_producto());
            $sentencia->bindParam(":p_stock", $this->getStock());
            $sentencia->bindParam(":p_codigo_categoria", $this->getCodigoCategoria());
            $sentencia->bindParam(":p_codigo_marca", $this->getCodigoMarca());
            $sentencia->bindParam(":p_codigo_producto", $this->getCodigoProducto());
            $sentencia->bindParam(":p_ubicacion", $this->getUbicacion());
            $sentencia->execute();

            $this->dbLink->commit();

            return TRUE; //El producto se actualizó correctamente
        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
    }
    public function buscarArticulo($nombreArticulo) {
        try {
            $sql = "
                    select 
                        codigo_producto, 
                        nombre, 
                        precio_venta 
                    from 
                        producto 
                    where
                        upper(nombre) like :p_na
                ";

            $sentencia = $this->dbLink->prepare($sql);
            $nombreArticulo = '%'.strtoupper($nombreArticulo).'%';
            $sentencia->bindParam(":p_na", $nombreArticulo);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    public function articulosCategoria() {
        try {
            $sql = "
                SELECT 
                    categoria.descripcion as categoria,
                    COUNT(*) as cantidad
                  FROM 
                    public.producto, 
                    public.categoria
                  WHERE 
                    categoria.codigo_categoria = producto.codigo_categoria
                  group by
                          categoria.descripcion
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



