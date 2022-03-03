<?php
session_start();

require("vendor/autoload.php");
require("app/configuration.php");

use Slim\Slim;

$router = new Slim();

$router->get('/', function (){
    $homeController = new \App\Controllers\HomeController();
    $homeController->index();
});

$router->run();