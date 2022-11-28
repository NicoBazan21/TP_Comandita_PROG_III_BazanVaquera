<?php

require_once './models/Pedido.php';
require_once './models/Encuesta.php';

class ClientesController
{
    public function Demora($request, $response)
    {
        if(isset($_GET['id_pedido']) && isset($_GET['id_mesa']))
        {
            $pedido = Pedido::obtenerDemora($_GET['id_mesa']);

            if($pedido)
            {
                $payload = json_encode(array("Mesa"=>$pedido->id_mesa, "Tiempo de finalizacion"=>$pedido->tiempo_finalizacion." minutos"));
            }
            else
            {
                $payload = json_encode(array("Estado"=>"Mesa o pedido no encontrado"));
            }

            $response->getBody()->write($payload);
        }

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function Encuesta($request, $response)
    {
        $parametros = $request->getParsedBody();
        if(isset($parametros['id_mesa']) && isset($parametros['id_pedido'])
        && isset($parametros['calificacion']) && isset($parametros['comentarios']))
        {
            $encuesta = new Encuesta();
            $encuesta->id_mesa = $parametros['id_mesa'];
            $encuesta->id_pedido = $parametros['id_pedido'];
            $encuesta->calificacion = $parametros['calificacion'];
            $encuesta->comentarios = $parametros['comentarios'];

            $encuesta->crearEncuesta();

            $payload = json_encode(array("Estado"=>"Encuesta realizada"));
        }
        else
        {
            $payload = json_encode(array("Estado"=>"Peticion incompleta"));
        }
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }
}


?>