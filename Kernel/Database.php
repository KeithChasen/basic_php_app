<?php

namespace Kernel;

use PDO;
use Exception;

class Database
{
    /**
     * @param $config
     * @return PDO
     * @throws Exception
     */
    public static function getPDOConnection($config)
    {

        if (is_array($config)) {
            list($driver, $host, $dbname, $port, $dbusername, $dbpassword) = array_values($config);

            $dsn = "{$driver}:host={$host};dbname={$dbname};port={$port}";

            return new PDO($dsn,$dbusername,$dbpassword);
        }

        throw new Exception('Unable to connect to database');
    }

}