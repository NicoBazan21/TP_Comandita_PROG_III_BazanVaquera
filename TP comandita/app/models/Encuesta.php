<?php

class Encuesta
{
    public $id_mesa;
    public $id_pedido;
    public $calificacion;
    public $comentarios;

    public function crearEncuesta()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO encuestas (id_pedido, id_mesa, calificacion, comentarios)
         VALUES (:id_pedido, :id_mesa, :calificacion, :comentarios)");

        $consulta->bindValue(':id_pedido', $this->id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':id_mesa', $this->id_mesa, PDO::PARAM_INT);
        $consulta->bindValue(':calificacion', $this->calificacion, PDO::PARAM_INT);
        $consulta->bindValue(':comentarios', $this->comentarios, PDO::PARAM_STR);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function listarMejores()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * from encuestas ORDER BY calificacion DESC;");
        
        $consulta->execute();
    
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Encuesta');
    }
}

?>