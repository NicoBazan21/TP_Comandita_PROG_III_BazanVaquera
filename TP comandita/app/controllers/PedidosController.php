<?php
require_once './models/Pedido.php';

class PedidosController
{
    public static function CargarAux($parametros)
    {
        $pedido = new Pedido();
        $pedido->descripcion = $parametros->descripcion;
        $pedido->estado = $parametros->estado;
        $pedido->precio = $parametros->precio;
        $pedido->id_mesa = $parametros->id_mesa;

        $pedido->crearPedido();
    }
    public static function Cargar($request, $response)
    {
        $array = $_FILES;
        $array['pedidos']['tmp_name'];

        //var_dump($array['pedidos']['tmp_name']);
       
        $archivo = fopen($array['pedidos']['tmp_name'],"r");
        $lista = array();

        while(!feof($archivo))
        {
            $linea = fgets($archivo);
            if(!empty($linea))
            {
                $datos = explode(",",$linea);
                $agregar = new Pedido();
                $agregar->id_pedido = $datos[0];
                $agregar->descripcion = $datos[1];
                $agregar->estado = $datos[2];
                $agregar->tiempo_finalizacion = $datos[3];
                $agregar->precio = $datos[4];
                $agregar->id_mesa = $datos[5];
                array_push($lista,$agregar);
            }
        }  
        //var_dump($lista);
        //echo $lista[0]->id_pedido;

        for($i = 0; $i < count($lista); $i++)
        {
            PedidosController::CargarAux($lista[$i]);
        }

        fclose($archivo);
        
        return $response;
    }
    public static function Descargar($request, $response)
    {
        $lista = Pedido::obtenerTodos();
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=pedidos.csv');

        //$archivo = fopen("C:\\xampp\\htdocs\\Programacion 3\\TP comandita\\app\\pedidos.csv","a+");
        $archivo = fopen('php://output', "a+");
        
        $cant = count($lista);
        $claves = array_keys($lista);

        foreach($lista as $clave => $pedido)
        {

            fwrite($archivo,$pedido->id_pedido.","
            .$pedido->descripcion.","
            .$pedido->estado.","
            .$pedido->tiempo_finalizacion.","
            .$pedido->precio.","
            .$pedido->id_mesa.","
            .PHP_EOL);
        }
        fclose($archivo);

        return $response;
    }
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
