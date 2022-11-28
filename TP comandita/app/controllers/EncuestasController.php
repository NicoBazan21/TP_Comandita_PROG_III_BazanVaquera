<?php

require_once './models/Encuesta.php';

class EncuestasController
{
    public function ListarMejoresCom($request, $response)
    {
        $lista = Encuesta::listarMejores();
        $payload = json_encode(array("Lista"=>$lista));

        $response->getBody()->write($payload);

        return $response;
    }
}

?>