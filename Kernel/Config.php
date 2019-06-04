<?php

namespace Kernel;

class Config
{
    /**
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public static function parse(string $key) {

        $filePath = __DIR__ . '/../config/' . $key . '.php';

        if (is_file($filePath)) {
            return require_once($filePath);
        }

        throw new \Exception($key . '.php file wasn\'t found');
    }

}