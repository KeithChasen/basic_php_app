<?php

namespace App\Services;

use Illuminate\Hashing\BcryptHasher;

class AuthService extends BasicService
{
    private $bcrypt;

    /**
     * AuthService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->bcrypt = new BcryptHasher();
    }

    /**
     * @param $email
     * @param $password
     * @return array
     */
    public function register($email, $password)
    {
        $userExists = $this->getUserByEmail($email);

        if (!empty($userExists)) {
            return [
                'ok' => false,
                'message' => 'User with such email already exists. Please log in.'
            ];
        }

        $password = $this->bcrypt->make($password);

        $pdo = $this->getPdo();
        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
        $newUser = $pdo->prepare($sql);
        $newUser->execute([$email, $password]);

        if ($pdo->lastInsertId()) {
            return [
                'ok' => true,
                'message' => 'Successfully registered. Now you can log in.'
            ];
        }

        return [
            'ok' => false,
            'message' => 'Something went wrong. Please try again'
        ];

    }

    /**
     * @param $email
     * @param $password
     * @return array
     */
    public function login($email, $password)
    {
        $user = $this->getUserByEmail($email);

        $passwordsMatch = $this->bcrypt->check($password, $user['password']);

        if ($passwordsMatch) {
            return [
                'ok' => true,
                'user' => [
                    'id' => $user['id'],
                    'email' => $user['email']
                ],
                'message' => 'Successfully logged in'
            ];
        }

        return [
            'ok' => false,
            'user' => null,
            'message' => 'Credentials might be wrong'
        ];
    }

    /**
     * @param $email
     * @return mixed
     */
    protected function getUserByEmail($email)
    {
        $pdo = $this->getPdo();

        $sql = "SELECT * FROM users WHERE email = ?";

        $attemptLogin = $pdo->prepare($sql);
        $attemptLogin->execute([$email]);

        return $attemptLogin->fetch($pdo::FETCH_ASSOC);
    }

}