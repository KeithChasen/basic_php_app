<?php

namespace App\Services;

use Kernel\Database;

class BasicService
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = Database::getPDOConnection();
    }

    protected function getPdo()
    {
        return $this->pdo;
    }

}