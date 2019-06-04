<?php

require_once __DIR__ . '/../helpers.php';

use Kernel\Database;
use Kernel\Config;
use Dotenv\Dotenv;

try {
    Dotenv::create(__DIR__ . '/../')->load();

    $pdo = Database::getPDOConnection(Config::parse('db'));

    $router = require_once __DIR__ . '/../app/router.php';

    $dispatcher = new \Phroute\Phroute\Dispatcher($router->getData());

    $response = $dispatcher->dispatch(
        $_SERVER['REQUEST_METHOD'],
        parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
    );

    echo $response;

} catch (Exception $e) {
    printException($e);
}