<?php

class Cocinero
{
    public $id_cocinero;
    public $id_pedido;
    public $estado;
    public $descripcion;
    public $estado_cocinero;
    public $tiempo;

    public function crearcocinero()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO cocineros (id_pedido, estado, descripcion, estado_cocinero, tiempo)
         VALUES (:id_pedido, :estado, :descripcion, :estado_cocinero, :tiempo)");
        $consulta->bindValue(':id_pedido', $this->id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(':estado_cocinero', $this->estado_cocinero, PDO::PARAM_STR);
        $consulta->bindValue(':tiempo', $this->tiempo, PDO::PARAM_INT);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }
    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM cocineros");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Cocinero');
    }

    public static function obtenerPendiente($id_pedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM productos where estado = 'Esperando' and area = 'Cocina' and id_pedido = :id_pedido");
        $consulta->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Producto');
    }

    public static function obtenerLibre()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM `cocineros` WHERE estado_cocinero = 'Libre' LIMIT 1");
        $consulta->execute();

        return $consulta->fetchObject('Cocinero');
    }

    public static function prepararProducto($cocinero, $producto)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE cocineros
        SET estado_cocinero = 'Ocupado', id_pedido = :id_pedido ,
         descripcion = :descripcion, tiempo = :tiempo, estado = 'En preparacion'
        WHERE id_cocinero = :id_cocinero");

        $consulta->bindValue(':id_cocinero', $cocinero->id_cocinero, PDO::PARAM_INT);
        $consulta->bindValue(':id_pedido', $producto->id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':descripcion', $producto->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(':tiempo', rand(1,60), PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Cocinero');
    }

    public static function cambiarEstado($id_pedido, $estado, $estado_cocinero)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE cocineros SET estado = :estado, estado_cocinero = :estado_cocinero WHERE id_pedido = :id_pedido LIMIT 1");
        $consulta->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $estado, PDO::PARAM_STR);
        $consulta->bindValue(':estado_cocinero', $estado_cocinero, PDO::PARAM_STR);

        $consulta->execute();

        return $consulta->fetchObject('Cocinero');
    }

    
}

?>