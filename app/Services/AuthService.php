<?php

namespace App\Services;

use Illuminate\Hashing\BcryptHasher;
use Lcobucci\JWT\Builder;

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

            $token = $this->createToken($user);

            return [
                'ok' => true,
                'user' => [
                    'id' => $user['id'],
                    'email' => $user['email']
                ],
                'token' => $token,
                'message' => 'Successfully logged in'
            ];
        }

        return [
            'ok' => false,
            'user' => null,
            'token' => null,
            'message' => 'Credentials might be wrong'
        ];
    }

    /**
     * @param $user
     * @return string
     */
    protected function createToken($user)
    {
        $time = time();

        return (new Builder())
            ->issuedAt($time)
            ->issuedBy(getenv('URL'))
            ->permittedFor(getenv('URL'))
            ->identifiedBy(getenv('TOKEN_SECRET'), true)
            ->canOnlyBeUsedAfter($time + 60)
            ->expiresAt($time + 3600)
            ->withClaim('id', $user['id'])
            ->withClaim('email', $user['email'])
            ->getToken()->__toString();
    }

}