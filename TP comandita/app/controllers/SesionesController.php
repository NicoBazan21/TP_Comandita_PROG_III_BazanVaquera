<?php
require_once './models/Sesiones.php';

class SesionesController
{   
    public static function Autenticar($request, $response)
    {
      $parametros = $request->getParsedBody();

      $sesion = new Sesion();
      $sesion->area = $parametros['area'];
      $sesion->clave = $parametros['clave'];
      
      $lista = Sesion::obtenerSesion($sesion->area);
      
      if($sesion->area == $lista->area
      && $sesion->clave == $lista->clave)
      {
        return $lista->area;
      }
      else
      {
        return false;
      }
    }
}

?>