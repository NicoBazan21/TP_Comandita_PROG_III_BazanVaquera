<?php

class Producto
{
    public $id_producto;
    public $area;
    public $descripcion;
    public $estado;
    public $id_pedido;

    public function crearProducto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productos (descripcion, estado, area, id_pedido)
         VALUES (:descripcion, :estado ,:area, :id_pedido)");
        $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->bindValue(':area', $this->area, PDO::PARAM_STR);
        $consulta->bindValue(':id_pedido', $this->id_pedido, PDO::PARAM_INT);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerPendientes($area)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM productos where estado = 'Esperando' and area = :area");
        $consulta->bindValue(':area', $area, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

    public static function cambiarEstado($id_pedido, $area, $estado)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE productos SET estado = :estado where id_pedido = :id_pedido and area = :area");
        $consulta->bindValue(':area', $area, PDO::PARAM_STR);
        $consulta->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $estado, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Producto');
    }

    public static function obtenerPorPedidoYArea($area, $id_pedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * from productos where area = :area and id_pedido = :id_pedido");
        $consulta->bindValue(':area', $area, PDO::PARAM_STR);
        $consulta->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Producto');
    }
}

?>