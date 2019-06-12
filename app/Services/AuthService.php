<?php

namespace App\Services;

use Illuminate\Hashing\BcryptHasher;

class AuthService extends BasicService
{
    public function register($email, $password)
    {
        //todo: check if user with provided email already exists;

        $pdo = $this->getPdo();

        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";

        $newUser = $pdo->prepare($sql);

        $bcrypt = new BcryptHasher();
        $password = $bcrypt->make($password);

        $newUser->execute([$email, $password]);

        return $pdo->lastInsertId();
    }

}