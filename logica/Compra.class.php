<?php

require_once '../datos/Conexion.class.php';

class Compra extends Conexion {

     private $nroCompra;
    private $codigoTipoComprobante;
    private $rucProveedor;
    private $numeroSerie;
    private $numeroDocumento;
    private $fechaCompra;
    private $porcentajeIgv;
    private $subTotal;
    private $igv;
    private $total;
    private $codigoUsuario;
    private $detalle;
    function getNroCompra() {
        return $this->nroCompra;
    }

    function getCodigoTipoComprobante() {
        return $this->codigoTipoComprobante;
    }

    function getRucProveedor() {
        return $this->rucProveedor;
    }

    function getNumeroSerie() {
        return $this->numeroSerie;
    }

    function getNumeroDocumento() {
        return $this->numeroDocumento;
    }

    function getFechaCompra() {
        return $this->fechaCompra;
    }

    function getPorcentajeIgv() {
        return $this->porcentajeIgv;
    }

    function getSubTotal() {
        return $this->subTotal;
    }

    function getIgv() {
        return $this->igv;
    }

    function getTotal() {
        return $this->total;
    }

    function getCodigoUsuario() {
        return $this->codigoUsuario;
    }

    function getDetalle() {
        return $this->detalle;
    }

    function setNroCompra($nroCompra) {
        $this->nroCompra = $nroCompra;
    }

    function setCodigoTipoComprobante($codigoTipoComprobante) {
        $this->codigoTipoComprobante = $codigoTipoComprobante;
    }

    function setRucProveedor($rucProveedor) {
        $this->rucProveedor = $rucProveedor;
    }

    function setNumeroSerie($numeroSerie) {
        $this->numeroSerie = $numeroSerie;
    }

    function setNumeroDocumento($numeroDocumento) {
        $this->numeroDocumento = $numeroDocumento;
    }

    function setFechaCompra($fechaCompra) {
        $this->fechaCompra = $fechaCompra;
    }

    function setPorcentajeIgv($porcentajeIgv) {
        $this->porcentajeIgv = $porcentajeIgv;
    }

    function setSubTotal($subTotal) {
        $this->subTotal = $subTotal;
    }

    function setIgv($igv) {
        $this->igv = $igv;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setCodigoUsuario($codigoUsuario) {
        $this->codigoUsuario = $codigoUsuario;
    }

    function setDetalle($detalle){
        $this->detalle = $detalle;
    }

            public function listar($fecha1, $fecha2, $tipo) {
        try {
            $sql = "select * from f_listado_compra(:p_fecha1, :p_fecha2, :p_tipo);";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_fecha1", $fecha1);
            $sentencia->bindParam(":p_fecha2", $fecha2);
            $sentencia->bindParam(":p_tipo", $tipo);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
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
                $sql = "insert into compra 
                        (
                            numero_compra,
                            codigo_tipo_comprobante,
                            ruc_proveedor,
                            numero_serie,
                            numero_documento,
                            fecha_compra,
                            porcentaje_igv,
                            sub_total,
                            igv,
                            total,
                            codigo_usuario
                        )
                        values
                        (
                            :p_nc,
                            :p_tc,
                            :p_rp,
                            :p_ns,
                            :p_nd,
                            :p_fc,
                            :p_pi,
                            :p_st,
                            :p_igv,
                            :p_to,
                            :p_cu
                        )";

                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_nc", $this->getNroCompra());
                $sentencia->bindParam(":p_tc", $this->getCodigoTipoComprobante());
                $sentencia->bindParam(":p_rp", $this->getRucProveedor());
                $sentencia->bindParam(":p_ns", $this->getNumeroSerie());
                $sentencia->bindParam(":p_nd", $this->getNumeroDocumento());
                $sentencia->bindParam(":p_fc", $this->getFechaCompra());
                $sentencia->bindParam(":p_pi", $this->getPorcentajeIgv());
                $sentencia->bindParam(":p_st", $this->getSubTotal());
                $sentencia->bindParam(":p_igv", $this->getIgv());
                $sentencia->bindParam(":p_to", $this->getTotal());
                $sentencia->bindParam(":p_cu", $this->getCodigoUsuario());
                
                $sentencia->execute();
                  $datosDetalle = json_decode( $this->getDetalle() );
                
                foreach ($datosDetalle as $key => $value) { //permite recorrer el array
                    $sql = "insert into 
                        compra_detalle 
                        values(
                        :p_nc, 
                        :p_ca, 
                        :p_item, 
                        :p_can,
                        :p_pre,
                        :p_imp
                        )";
                $sentencia = $this->dblink->prepare($sql);
                    $sentencia->bindParam(":p_nc", $this->getNroCompra() );
                    $sentencia->bindParam(":p_ca", $value->codigoProducto );
                    $sentencia->bindParam(":p_item", $value->item );
                    $sentencia->bindParam(":p_can", $value->cantidad );
                    $sentencia->bindParam(":p_pre", $value->precio );
                    $sentencia->bindParam(":p_imp", $value->importe);
                    $sentencia->execute();

                /* Actualizar el correlativo para la tabla producto en + 1 */
                $sql = "update articulo 
                                    set stock = stock + :p_can 
                            where   
                                    codigo_producto = :p_ca";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_can", $value->cantidad);
                $sentencia->bindParam(":p_ca", $value->codigoArticulo);
                $sentencia->execute();


                //Confirmar la transacción
             

            } 
            $sql = "update correlativo set numero=numero+1 where tabla='compra'";
                $sentencia = $this->dbLink->prepare($sql);
               
                $sentencia->execute(); 
            $this->dbLink->commit();
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
        return true;
    }

    public function leerDatos($p_codigo_producto) {
        try {
            $sql = "SELECT 
                    codigo_producto, 
                    nombre, 
                    precio_venta, 
                    tipo_producto,
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
                    codigo_categoria            =:p_codigo_categoria,
                    codigo_marca		=:p_codigo_marca, 
                    ubicacion   		=:p_ubicacion 
                    
             WHERE 
                    codigo_producto = :p_codigo_producto;";

            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->bindParam(":p_nombre", $this->getNombre());
            $sentencia->bindParam(":p_precio_venta", $this->getPrecioVenta());
            $sentencia->bindParam(":p_tipo_producto", $this->getTipo_producto());
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
            $sentencia = $this->dblink->prepare($sql);
            $nombreArticulo = '%'.strtoupper($nombreArticulo).'%';
            $sentencia->bindParam(":p_na", $nombreArticulo);
            $sentencia->execute();
            $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $registros;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function articulosCategoria() {
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
        
        
        $sentencia = $this->dblink->prepare($sql);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
        
    }

    public function anular() {
       $this->dblink->beginTransaction();
        try {
            $sql = "select codigo_articulo, cantidad from compra_detalle where numero_compra = :p_nro_compra";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_nro_compra", $this->getNroCompra());
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            for ($i = 0; $i < count($resultado); $i++) {
                $sql = "update articulo set stock = stock - :p_cantidad where codigo_articulo = :p_codigo_articulo";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_cantidad", $resultado[$i]["cantidad"]);
                $sentencia->bindParam(":p_codigo_articulo", $resultado[$i]["codigo_articulo"]);
                $sentencia->execute();
            }
            
            $sql = "update compra set estado = 'A' where numero_compra = :p_nro_compra";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_nro_compra", $this->getNroCompra());
            $sentencia->execute();
            
            $this->dblink->commit();
            
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
        return true;
    }
    
    
} 




