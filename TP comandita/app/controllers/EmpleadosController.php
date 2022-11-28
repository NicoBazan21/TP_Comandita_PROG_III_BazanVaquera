<?php

require_once './models/Bartender.php';
require_once './models/Cervecero.php';
require_once './models/Cocinero.php';
require_once './models/Mozo.php';
require_once './models/Pedido.php';
require_once './models/Producto.php';

class EmpleadosController
{
    public function ListoParaServir($request, $response)
    {
        $parametros = $request->getParsedBody();
        if(isset($parametros['id_pedido']))
        {
        /*switch($parametros['area'])
        {
            case 'cocinero':*/
                Cocinero::cambiarEstado($parametros['id_pedido'], "Listo para servir", "Libre");
                Producto::cambiarEstado($parametros['id_pedido'], "Cocina", "Listo para servir");
                $payload = json_encode(array("Pedido Nº ".$parametros['id_pedido'] => "Listo para servir", "Area"=>"Cocinero"));
               /*break;
            case 'bartender':*/
                Bartender::cambiarEstado($parametros['id_pedido'], "Listo para servir", "Libre");
                Producto::cambiarEstado($parametros['id_pedido'], "Bartender", "Listo para servir");
                $payload = json_encode(array("Pedido Nº ".$parametros['id_pedido'] => "Listo para servir", "Area"=>"Bartender"));
                /*break;
            case 'cervecero':*/
                Cervecero::cambiarEstado($parametros['id_pedido'], "Listo para servir", "Libre");
                Producto::cambiarEstado($parametros['id_pedido'], "Cerveceria", "Listo para servir");
                $payload = json_encode(array("Pedido Nº ".$parametros['id_pedido'] => "Listo para servir", "Area"=>"Cervecero"));
                /*break;
        }*/
        }
        $response->getBody()->write($payload);
        
        return $response;
    }

    public function Preparar($request, $response)
    {
        $parametros = $request->getParsedBody();
        if(isset($parametros['id_pedido']))
        {
        /*switch($parametros['area'])
        {
            case 'cocinero':*/
                $producto = Cocinero::obtenerPendiente($parametros['id_pedido']);
                $cocinero = Cocinero::obtenerLibre();
                if($producto)
                {
                    if($cocinero)
                    {
                        Cocinero::prepararProducto($cocinero, $producto);
                        Producto::cambiarEstado($parametros['id_pedido'], "Cocina", "Preparando");
                        $payload = json_encode(array("Cocinero preparando" => $producto->descripcion));
                    }
                    else
                    {
                        $payload = json_encode(array("Estado de la cocina" => "No hay cocineros libres"));
                    }
                }
            /*    break;
            case 'bartender':*/
                $producto = Bartender::obtenerPendiente($parametros['id_pedido']);
                $bartender = Bartender::obtenerLibre();
                if($producto)
                {
                    if($bartender)
                    {
                        Bartender::prepararProducto($bartender, $producto);
                        Producto::cambiarEstado($parametros['id_pedido'], "Bartender", "Preparando");
                        $payload = json_encode(array("bartender preparando" => $producto->descripcion));
                    }
                    else
                    {
                        $payload = json_encode(array("Estado del bar" => "No hay bartenders libres"));
                    }
                }
            /*    break;
            case 'cervecero':*/
                $producto = Cervecero::obtenerPendiente($parametros['id_pedido']);
                $cervecero = Cervecero::obtenerLibre();
                if($producto)
                {
                    if($cervecero)
                    {
                        Cervecero::prepararProducto($cervecero, $producto);
                        Producto::cambiarEstado($parametros['id_pedido'], "Cerveceria", "Preparando");
                        $payload = json_encode(array("cervecero preparando" => $producto->descripcion));
                    }
                    else
                    {
                        $payload = json_encode(array("Estado de la cerveceria" => "No hay cerveceros libres"));
                    }
                }
              /*  break;
        }*/
            Pedido::establecerEstado($parametros['id_pedido'], rand(1,60), "En preparacion");

        }   
        
        $response->getBody()->write($payload);

        return $response;
    }
    public function ListarEmpleado($request, $response)
    {
        
        switch($_GET['empleado'])
        {       
            case "bartender":
                $lista = Bartender::obtenerTodos();
                $payload = json_encode(array("Lista bartender" => $lista));
                $response->getBody()->write($payload);
                break;
            case "cervecero":
                $lista = Cervecero::obtenerTodos();
                $payload = json_encode(array("Lista Cervecero" => $lista));
                $response->getBody()->write($payload);
                break;
            case "mozo":
                $lista = Mozo::obtenerTodos();
                $payload = json_encode(array("Lista mozo" => $lista));
                $response->getBody()->write($payload);
                break;
            case "cocinero":
                $lista = Cocinero::obtenerTodos();
                $payload = json_encode(array("Lista cocinero" => $lista));
                $response->getBody()->write($payload);
                break;
        }

        return $response
        ->withHeader('Content-Type', 'application/json');
    }
    public function CrearEmpleado($request, $response)
    {
        $parametros = $request->getParsedBody();

        switch($parametros['empleado'])
        {
            case "bartender":
                $bartender = new Bartender();

                $bartender->id_pedido = 0;
                $bartender->estado = "";
                $bartender->descripcion = "";
                $bartender->estado_bartender = "Libre";
                $bartender->tiempo = 0;

                $bartender->crearbartender();
                $payload = json_encode(array("mensaje" => "Bartender creado con exito"));
                break;
            case "cervecero":
                $cervecero = new Cervecero();

                $cervecero->id_pedido = 0;
                $cervecero->estado = "";
                $cervecero->descripcion = "";
                $cervecero->estado_cervecero = "Libre";
                $cervecero->tiempo = 0;

                $cervecero->crearCervecero();
                $payload = json_encode(array("mensaje" => "Cervecero creado con exito"));
                break;
            case "mozo":
                $mozo = new Mozo();
                $mozo->nombre = $parametros['nombre'];
                $mozo->id_pedido = 1;
                $mozo->id_mesa = 1;

                $mozo->crearMozo();

                $payload = json_encode(array("mensaje" => "Mozo creado con exito"));
            break;
            case "cocinero":
                $cocinero = new Cocinero();

                $cocinero->id_pedido = 0;
                $cocinero->estado = "";
                $cocinero->descripcion = "";
                $cocinero->estado_cocinero = "Libre";
                $cocinero->tiempo = 0;

                $payload = json_encode(array("mensaje" => "Cocinero creado con exito"));
                $cocinero->crearcocinero();
                break;
        }
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}

?>