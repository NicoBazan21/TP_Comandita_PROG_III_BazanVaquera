<?php

class Sesion
{
    public $sesion;
    public $clave;

    public static function obtenerSesion($area)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM sesiones WHERE area = :area");
        $consulta->bindValue(':area', $area, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Sesion');
    }
}

?>