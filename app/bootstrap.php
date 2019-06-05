<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../config/router.php';

use Kernel\Database;
use Kernel\Config;
use Dotenv\Dotenv;
use Kernel\HTTP;

try {
    Dotenv::create(__DIR__ . '/../')->load();

    $pdo = Database::getPDOConnection(Config::parse('db'));

    HTTP::run($routes);

} catch (Exception $e) {
    printException($e);
}