<?php

require_once './models/Mesa.php';

class MesasController
{
    public static function CrearMesa($request, $response)
    {
        $parametros = $request->getParsedBody();
        if(isset($parametros['id_mesa']))
        {
            $mesa = new Mesa();
            $mesa->id_mesa = $parametros['id_mesa'];

            $mesa->crearMesa();

            $payload = json_encode(array("Estado:"=>"Mesa creada"));
        }
        else
        {
            $payload = json_encode(array("Estado:"=>"Peticion incompletaa"));
            $response->withStatus(400);
        }

        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function Cerrarmesa($request, $response)
    {
        $parametros = $request->getParsedBody();

        if(isset($parametros['id_mesa']))
        {
            $mesa = new Mesa();
            $mesa->id_mesa = $parametros['id_mesa'];
            $mesa->estado = "Cerrada";
            $mesa->cambiarEstado();
            $payload = json_encode(array("Estado:"=>"Mesa cerrada"));
        }
        else
        {
            $payload = json_encode(array("Estado:"=>"Peticion incompletaa"));
            $response->withStatus(400);
        }
        $response->getBody()->write($payload);

        return $response;
    }
}


?>