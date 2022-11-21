<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class SoloAdminMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = new response();

        $todoOk = false;
        $parametros = $request->getParsedBody();

        if(!empty($request->getHeaderLine('Authorization'))
        && isset($parametros['area']) 
        && !empty($parametros['area']))
        {
            $header = $request->getHeaderLine('Authorization');
            $token = trim(explode("Bearer", $header)[1]);
            $todoOk = true;
            $area = $parametros['area'];
        }
    
        if($todoOk) 
        {  

            $datos = AutentificadorJWT::ObtenerPayLoad($token);

            if($area == $datos->data->area
            && $datos->data->area === 'admin')
            {
                $payload = json_encode(array("Estado:"=>"Autenticado.", "area: "=>$datos->data->area));
                $response = $handler->handle($request);

                $response = $response->withStatus(200);
            }
            else
            {
                $payload = json_encode(array("Estado:"=>"Rechazado", "area del token:"=>$datos->data->area, "Detalle:"=>"area no coincidente o no es administrador"));
                $response = $response->withStatus(401);
            }
        }
        else
        {   
            $payload = json_encode(array("Estado:"=>"Peticion incompleta"));
            $response = $response->withStatus(400);
            
        }
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }   
}

?>