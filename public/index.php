<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../helpers.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::create(__DIR__ . '/../');
$dotenv->load();

$driver = getenv('NETCE_DB_DRIVER');
$host = getenv('NETCE_DB_HOST');
$dname = getenv('NETCE_DB_NAME');
$port = getenv('NETCE_DB_PORT');
$dbusername = getenv('NETCE_DB_USER');
$dbpassword = getenv('NETCE_DB_PASSWORD');

$dsn = "{$driver}:host={$host};dbname={$dname};port={$port}";

try {
    $pdo = new PDO($dsn,$dbusername,$dbpassword);
} catch (Exception $e) {
    printException($e);
}


