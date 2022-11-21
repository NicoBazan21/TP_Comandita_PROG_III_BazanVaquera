<?php

error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;
//Bazan Vaquera, Nicolas Jose Antonio

require __DIR__ . '/../vendor/autoload.php';
//db y modelos
require_once './db/AccesoDatos.php';
require_once './models/Bartender.php';
require_once './models/Cervecero.php';
require_once './models/Cocinero.php';
require_once './models/Mozo.php';
require_once './models/Pedido.php';


require_once './controllers/TokensController.php';
require_once './controllers/EmpleadosController.php';
require_once './controllers/MozosController.php';
require_once './controllers/ClientesController.php';

/*//controllers
require_once './controllers/TokensController.php';
require_once './controllers/UsuarioController.php';
require_once './controllers/CriptoController.php';
require_once './controllers/VentasController.php';

//interfaces
require_once './interfaces/ITokensUsable.php';

//middlewares
require_once './middlewares/AutentificadorJWT.php';
require_once './middlewares/VerificarTokenMiddleware.php';
require_once './middlewares/SoloAdminMiddleware.php';
require_once './middlewares/UserExistenteMiddleware.php';*/

require_once './middlewares/AutentificadorJWT.php';
require_once './middlewares/SoloAdminMiddleware.php';
require_once './middlewares/SoloMozosMiddleware.php';
require_once './middlewares/EmpleadoMiddleware.php';

// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

//Para correr una base de datos local
$app->setBasePath('/Programacion 3/TP comandita/app');

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

$app->group('/mozo', function (RouteCollectorProxy $group)
{
  $group->post('/tomarPedido', \MozosController::class . ':TomarPedido');
  $group->post('/tomarFoto', \MozosController::class . ':TomarFoto');
  $group->post('/servir', \MozosController::class . ':Servir');
  $group->post('/cobrar', \MozosController::class . ':CobrarCuenta');

})->add(new SoloMozosMiddleware);

$app->group('/empleado', function (RouteCollectorProxy $group)
{
  $group->post('/listar', \ProductosController::class . ':listarPendientes');
  $group->post('/preparar', \EmpleadosController::class . ':Preparar');
  $group->post('/listoParaServir', \EmpleadosController::class . ':ListoParaServir');

})->add(new EmpleadoMiddleware);

$app->group('/clientes', function (RouteCollectorProxy $group)
{
  $group->get('/demora/', \ClientesController::class . ':Demora');

});

$app->group('/admin', function (RouteCollectorProxy $group)
{
  $group->post('/altaEmpleado', \EmpleadosController::class . ':CrearEmpleado');
  $group->post('/demoras', \PedidosController::class . ':ListarPedidos');

})->add(new SoloAdminMiddleware);

$app->group('/listar', function (RouteCollectorProxy $group)
{
  $group->get('/empleado', \EmpleadosController::class . ':ListarEmpleado');

});

$app->group('/jwt', function (RouteCollectorProxy $group)
{
  $group->post('/crearToken', \TokensController::class . ':CrearToken');
});


$app->get('[/]', function (Request $request, Response $response) 
{    
    $response->getBody()->write("Slim Framework 4 PHP Nico");
    return $response;
});

$app->run();

?>