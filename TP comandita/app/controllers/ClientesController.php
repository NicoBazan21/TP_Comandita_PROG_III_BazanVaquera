<?php

require_once './models/Pedido.php';

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
}


?>