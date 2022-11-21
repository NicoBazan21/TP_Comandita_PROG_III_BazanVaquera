<?php

require_once './middlewares/AutentificadorJWT.php';
require_once './controllers/SesionesController.php';


class TokensController
{
    public function CrearToken($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $alias = $parametros['alias'];

      $tipo = SesionesController::Autenticar($request, $response);

      if($tipo)
      {
        $datos = array('area' => $parametros['area'], 'alias' => $alias);
        $token = AutentificadorJWT::CrearToken($datos);
        $payload = json_encode(array('jwt' => $token));
      }
      else
      {
        $payload = json_encode(array("Usuario inexistente"));        
      }
      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }
}

?>