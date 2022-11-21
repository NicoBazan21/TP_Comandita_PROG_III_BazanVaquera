<?php

class Bartender
{
    public $id_bartender;
    public $id_pedido;
    public $estado;
    public $descripcion;
    public $estado_bartender;
    public $tiempo;

    public function crearBartender()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO bartenders (id_pedido, estado, descripcion, estado_bartender, tiempo)
         VALUES (:id_pedido, :estado, :descripcion, :estado_bartender, :tiempo)");
        $consulta->bindValue(':id_pedido', $this->id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(':estado_bartender', $this->estado_bartender, PDO::PARAM_STR);
        $consulta->bindValue(':tiempo', $this->tiempo, PDO::PARAM_INT);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }
    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM bartenders");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Bartender');
    }

    public static function obtenerPendiente($id_pedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM productos where estado = 'Esperando' and area = 'Bartender' and id_pedido = :id_pedido");
        $consulta->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Producto');
    }

    public static function obtenerLibre()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM `bartenders` WHERE estado_bartender = 'Libre' LIMIT 1");
        $consulta->execute();

        return $consulta->fetchObject('Bartender');
    }

    public static function prepararProducto($bartender, $producto)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE bartenders
        SET estado_bartender = 'Ocupado', id_pedido = :id_pedido ,
         descripcion = :descripcion, tiempo = :tiempo, estado = 'En preparacion'
        WHERE id_bartender = :id_bartender");

        $consulta->bindValue(':id_bartender', $bartender->id_bartender, PDO::PARAM_INT);
        $consulta->bindValue(':id_pedido', $producto->id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':descripcion', $producto->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(':tiempo', rand(1,60), PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Bartender');
    }

    public static function cambiarEstado($id_pedido, $estado, $estado_bartender)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE bartenders SET estado = :estado, estado_bartender = :estado_bartender WHERE id_pedido = :id_pedido LIMIT 1");
        $consulta->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $estado, PDO::PARAM_STR);
        $consulta->bindValue(':estado_bartender', $estado_bartender, PDO::PARAM_STR);

        $consulta->execute();

        return $consulta->fetchObject('bartender');
    }

}




?>