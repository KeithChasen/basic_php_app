<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use App\ResourceController;

$routes = new RouteCollection();

$r = new Route('/resource');
$r->setMethods(['GET'])->setDefaults(['_controller' => [ResourceController::class, 'index']]);
$routes->add('resource', $r);

$r = new Route('/resource/store');
$r->setMethods(['POST'])->setDefaults(['_controller' => [ResourceController::class, 'store']]);
$routes->add('resource_add', $r);

$r = new Route('/resource/show/{id}');
$r->setMethods(['GET'])->setDefaults(['_controller' => [ResourceController::class, 'show']]);
$routes->add('resource_show', $r);

$r = new Route('/resource/update/{id}');
$r->setMethods(['PUT'])->setDefaults(['_controller' => [ResourceController::class, 'update']]);
$routes->add('resource_update', $r);

$r = new Route('/resource/destroy/{id}');
$r->setMethods(['DELETE'])->setDefaults(['_controller' => [ResourceController::class, 'destroy']]);
$routes->add('resource_delete', $r);

return $routes;