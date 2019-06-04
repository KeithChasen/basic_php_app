<?php

use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();

$router->get('/', function () {
    return 'this is the main';
});

$router->controller('/resource', 'App\\ResourceController');

return $router;

