<?php

namespace App\Services;

class AuthService extends BasicService
{
    public function register($email, $password)
    {
        //todo: check if user with provided email already exists;

        $pdo = $this->getPdo();

        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";

        $newUser = $pdo->prepare($sql);

        //todo: add bcrypt to password

        $newUser->execute([$email, $password]);

        return $pdo->lastInsertId();
    }

}