<?php

require_once './models/Producto.php';

class ProductosController
{
    public static function generarProducto($descripcion, $area, $id_pedido)
    {
        $producto = new Producto();
        $producto->descripcion = $descripcion;
        $producto->estado = "Esperando";
        $producto->area = $area;
        $producto->id_pedido = $id_pedido;
        $producto->crearProducto();
    }

    public function ListarPendientes($request, $response)
    {
        $parametros = $request->getParsedBody();

        if(isset($parametros['area']) && !empty($parametros['area']))
        {
            $area = $parametros['area'];
        }
        
        switch($area)
        {
            case 'cocinero':
                $lista = Producto::obtenerPendientes("Cocina");
                break;
            case 'cervecero':
                $lista = Producto::obtenerPendientes("Cerveceria");
                break;
            case 'bartender':
                $lista = Producto::obtenerPendientes("Bartender");
                break;
        }

        $payload = json_encode(array("Lista de pendientes" => $lista));
        
        $response->getBody()->write($payload);

        return $response;
    }
}

?>