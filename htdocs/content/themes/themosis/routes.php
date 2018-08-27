<?php

use Themosis\Core\Application;

$app = Application::getInstance();

$router = $app->make('router');

$router->get('home', function () {
    return "WordPress Home Page";
});

$router->get('/', function () {
    return "Home route";
});

/*$routes = $router->getRoutes();

dd($routes);*/
