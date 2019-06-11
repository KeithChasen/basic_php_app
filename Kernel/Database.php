<?php

namespace Kernel;

use PDO;
use Exception;

class Database
{
    use LostConnection;

    /**
     * @return PDO
     * @throws Exception
     */
    public static function getPDOConnection()
    {
        static $instance;

        $config = Config::parse('db');

        if (null === $instance) {
            try {
                return self::createPDO($config);
            } catch (Exception $e) {
                if (self::checkLostConnection($e)) {
                    return self::createPDO($config);
                }

                throw $e;
            }

        }

        return $instance;
    }

    private static function createPDO($config)
    {
        if (is_array($config)) {
            list($driver, $host, $dbname, $port, $dbusername, $dbpassword) = array_values($config);

            $dsn = "{$driver}:host={$host};dbname={$dbname};port={$port}";

            return new PDO($dsn,$dbusername,$dbpassword);
        }

    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }



}