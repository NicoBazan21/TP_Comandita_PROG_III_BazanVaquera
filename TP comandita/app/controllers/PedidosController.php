<?php
require_once './models/Pedido.php';

class PedidosController
{

    public static function generarPedido($request, $response)
    {
        $parametros = $request->getParsedBody();

        $pedido = new Pedido();
        $pedido->descripcion = $parametros['descripcion'];
        $pedido->estado = "Esperando";
        $pedido->precio = $parametros['precio'];
        $pedido->id_mesa = $parametros['mesa'];

        $pedido->id_pedido = $pedido->crearPedido();

        return $pedido->id_pedido;
    }

    public function ListarPedidos($request, $response)
    {
        $parametros = $request->getParsedBody();

        if(isset($parametros['id_mesa']))
        {
            $pedido = Pedido::obtenerDemora($parametros['id_mesa']);

            if($pedido)
            {
                $payload = json_encode(array("Mesa"=>$pedido->id_mesa, "Estado"=>$pedido->estado ,"Tiempo de finalizacion"=>$pedido->tiempo_finalizacion." minutos"));
            }
            else
            {
                $payload = json_encode(array("Estado"=>"Mesa o pedido no encontrado"));
            }
        }
        else
        {
            $lista = Pedido::obtenerTodos();
            $payload = json_encode(array("Lista"=>$lista));
        }

        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }
}

?>
