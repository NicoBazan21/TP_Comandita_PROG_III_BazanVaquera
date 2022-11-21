<?php

class Mozo
{
    public $id_mozo;
    public $id_pedido;
    public $id_mesa;
    public $nombre;

    public function crearMozo()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mozos (id_pedido, id_mesa, nombre) VALUES (:id_pedido,:id_mesa ,:nombre)");
        $consulta->bindValue(':id_pedido', $this->id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':id_mesa', $this->id_mesa, PDO::PARAM_INT);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }
    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM mozos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mozo');
    }
}


?>