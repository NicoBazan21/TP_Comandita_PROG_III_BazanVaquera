<?php

require_once './models/Pedido.php';
require_once './models/Producto.php';
require_once './controllers/PedidosController.php';
require_once './controllers/ProductosController.php';
require_once './controllers/MoverFotosController.php';

class MozosController
{
    public function CobrarCuenta($request, $response)
    {
        $parametros = $request->getParsedBody();
        if(isset($parametros['id_pedido']))
        {
            Pedido::establecerEstado($parametros['id_pedido'], 0, "Mesa cobrada");

            $payload = json_encode(array("Mesa Nº".$parametros['id_pedido'] => "Cobrada"));
            $response->getBody()->write($payload);
        }

        return $response;
    }
    public function Servir($request, $response)
    {
        $parametros = $request->getParsedBody();

        if(isset($parametros['id_pedido']))
        {
            $cocina = Producto::obtenerPorPedidoYArea("Cocina", $parametros['id_pedido']);
            $bartender = Producto::obtenerPorPedidoYArea("Bartender", $parametros['id_pedido']);
            $cerveceria = Producto::obtenerPorPedidoYArea("Cerveceria", $parametros['id_pedido']);

            if($cocina->estado == "Listo para servir"
            && $bartender->estado == "Listo para servir"
            && $cerveceria->estado == "Listo para servir")
            {
                Pedido::establecerEstado($parametros['id_pedido'], 0, "Servido");
                $payload = json_encode(array("Pedido" => "Servido"));
                $response->getBody()->write($payload);
            }
        }
        
        return $response;

    }
    public function TomarPedido($request, $response)
    {
        $parametros = $request->getParsedBody();
        if(!isset($parametros['descripcion']) || !isset($parametros['precio']) || !isset($parametros['mesa']))
        {
            $payload = json_encode(array("Pedido" => "Rechazado", "Estado" => "Pedido incompleto"));
            $request->withStatus(400);
            return $response;
        }

        $id_pedido = PedidosController::generarPedido($request, $response);

        if(isset($parametros['cocinero']) && !empty($parametros['cocinero']))
        {
            ProductosController::generarProducto($parametros['cocinero'], "Cocina", $id_pedido);
        }
        
        if(isset($parametros['cervecero']) && !empty($parametros['cervecero']))
        {
            ProductosController::generarProducto($parametros['cervecero'], "Cerveceria", $id_pedido);
        }

        if(isset($parametros['bartender']) && !empty($parametros['bartender']))
        {
            ProductosController::generarProducto($parametros['bartender'], "Bartender", $id_pedido);
        }

        $payload = json_encode(array("Pedido" => "Realizado", "Estado" => "Pedido en espera"));
        $response->getBody()->write($payload);
        
        return $response;
    }

    public function tomarFoto($request, $response)
    {
        $parametros = $request->getParsedBody();

        $pedido = Pedido::obtenerPorMesa($parametros['mesa']);

        if($parametros['mesa'] != $pedido->id_mesa)
        {
            $payload = json_encode(array("Estado" => "Mesa no encontrada"));
            $response->getBody()->write($payload);
        }
        else
        {
            try
            {
                $nombre = $pedido->id_mesa.$pedido->descripcion.".png";
                $mover = new MoverFotos("./FotosPedidos/", $_FILES, $nombre);

                $payload = json_encode(array("Estado" => "Foto tomada con exito"));
                $response->getBody()->write($payload);
            }
            catch(E $e)
            {
                $payload = json_encode(array("Estado" => "Error al mover fotos"));
                $response->getBody()->write($payload);
            }
        }
        return $response;
    }
}