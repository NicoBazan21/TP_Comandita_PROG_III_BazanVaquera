<?php

class Cervecero
{
    public $id_cervecero;
    public $id_pedido;
    public $estado;
    public $descripcion;
    public $estado_cervecero;
    public $tiempo;

    public function crearCervecero()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO cerveceros (id_pedido, estado, descripcion, estado_cervecero, tiempo) VALUES (:id_pedido, :estado, :descripcion, :estado_cervecero, :tiempo)");
        $consulta->bindValue(':id_pedido', $this->id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(':estado_cervecero', $this->estado_cervecero, PDO::PARAM_STR);
        $consulta->bindValue(':tiempo', $this->tiempo, PDO::PARAM_INT);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }
    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM cerveceros");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Cervecero');
    }

    public static function obtenerPendiente($id_pedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM productos where estado = 'Esperando' and area = 'Cerveceria' and id_pedido = :id_pedido");
        $consulta->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Producto');
    }

    public static function obtenerLibre()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM `cerveceros` WHERE estado_cervecero = 'Libre' LIMIT 1");
        $consulta->execute();

        return $consulta->fetchObject('Cervecero');
    }

    public static function prepararProducto($cervecero, $producto)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE cerveceros
        SET estado_cervecero = 'Ocupado', id_pedido = :id_pedido ,
         descripcion = :descripcion, tiempo = :tiempo, estado = 'En preparacion'
        WHERE id_cervecero = :id_cervecero");

        $consulta->bindValue(':id_cervecero', $cervecero->id_cervecero, PDO::PARAM_INT);
        $consulta->bindValue(':id_pedido', $producto->id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':descripcion', $producto->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(':tiempo', rand(1,60), PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Cervecero');
    }

    public static function cambiarEstado($id_pedido, $estado, $estado_cervecero)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE cerveceros SET estado = :estado, estado_cervecero = :estado_cervecero WHERE id_pedido = :id_pedido LIMIT 1");
        $consulta->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $estado, PDO::PARAM_STR);
        $consulta->bindValue(':estado_cervecero', $estado_cervecero, PDO::PARAM_STR);

        $consulta->execute();

        return $consulta->fetchObject('bartender');
    }
}




?>