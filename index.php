<?php
session_start();

require("vendor/autoload.php");
require("app/configuration.php");

use MiladRahimi\PhpRouter\Router;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use Laminas\Diactoros\Response\HtmlResponse;

use App\Controllers\UserController;

$router = Router::create();


// Exibe todos os usuarios
$router->get('/users', [UserController::class, 'index']);

// Cadastra um novo usuário
$router->get('/users/cadastro', [UserController::class, 'create']);
$router->post('/users/cadastro', [UserController::class, 'store']);

// Exibe um usuário especifico
$router->get('/users/{id}', [UserController::class, 'show']);

// Edita um usuário especifico
$router->get('/users/editar/{id}', [UserController::class, 'edit']);
$router->put('/users/editar', [UserController::class, 'update']);

// Deleta um usuário especifico
$router->post('/users/delete/{id}', [UserController::class, 'destroy']);


try {
    $router->dispatch();
} catch (RouteNotFoundException $e) {
    // It's 404!
    $router->getPublisher()->publish(new HtmlResponse('Not found.', 404));
} catch (Throwable $e) {
    // Log and report...
    $router->getPublisher()->publish(new HtmlResponse('Internal error.', 500));
}