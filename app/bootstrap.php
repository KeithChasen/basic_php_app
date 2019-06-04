<?php

require_once __DIR__ . '/../helpers.php';

use Kernel\Database;
use Kernel\Config;
use Dotenv\Dotenv;
use Phroute\Phroute\Dispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

try {
    Dotenv::create(__DIR__ . '/../')->load();

    $pdo = Database::getPDOConnection(Config::parse('db'));

    $request = Request::createFromGlobals();

    $response = new Response();

    $router = require_once __DIR__ . '/../app/router.php';

    $dispatcher = new Dispatcher($router->getData());

    $dispatched = $dispatcher->dispatch(
        $_SERVER['REQUEST_METHOD'],
        parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
    );

    $response->setContent($dispatched);

    $response->send();

} catch (Exception $e) {
    printException($e);
}