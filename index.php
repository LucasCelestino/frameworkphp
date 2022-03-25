<?php
session_start();

require("vendor/autoload.php");
require("app/configuration.php");

use MiladRahimi\PhpRouter\Router;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use Laminas\Diactoros\Response\HtmlResponse;

use App\Controllers\HomeController;

$router = Router::create();


$router->get('/user', [HomeController::class, 'index']);

$router->post('/cadastro', [HomeController::class, 'cadastroPost']);

try {
    $router->dispatch();
} catch (RouteNotFoundException $e) {
    // It's 404!
    $router->getPublisher()->publish(new HtmlResponse('Not found.', 404));
} catch (Throwable $e) {
    // Log and report...
    $router->getPublisher()->publish(new HtmlResponse('Internal error.', 500));
}