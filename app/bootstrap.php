<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../config/router.php';

use Dotenv\Dotenv;
use Kernel\HTTP;

use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

try {
    Dotenv::create(__DIR__ . '/../')->load();

    $fileLocator = new FileLocator();
    $yamlLoader = new YamlFileLoader($fileLocator);

    //if you prefer not to use yaml routes put $routes variable here as a parameter
    HTTP::run($yamlLoader->load(__DIR__ . '/../config/routes.yaml'));

} catch (Exception $e) {
    printException($e);
}