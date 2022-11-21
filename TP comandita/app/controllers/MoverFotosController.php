<?php

class MoverFotos
{
    public $direccion;
    public $extension;
    public $nombre;
    public $pathDireccion;

    public function __construct($direccion, $array, $nombre)
    {
        MoverFotos::CrearDirectorio($direccion);
        $this->direccion = $direccion;
        $this->Guardar($direccion,$array, $nombre);
    }

    private static function CrearDirectorio($direccion)
    {
        if (!file_exists($direccion)) 
        {
            mkdir($direccion);
        }
    }

    public function Guardar($direccion,$array,$nombre)
    {
        $todoOk = false;

        move_uploaded_file($array['Index']['tmp_name'], $direccion.$nombre);
    }

    public static function Mover($dirVieja ,$nuevaDireccion ,$nombreArch)
    {
        self::CrearDirectorio($nuevaDireccion);

        rename($dirVieja.$nombreArch, $nuevaDireccion.$nombreArch);
    }
}


?>