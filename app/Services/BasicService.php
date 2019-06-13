<?php

namespace App\Services;

use Kernel\Database;

use Symfony\Component\HttpFoundation\Request;
use Lcobucci\JWT\Parser;
use Exception;

class BasicService
{
    protected $pdo;
    private $jwtParser;

    /**
     * BasicService constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->pdo = Database::getPDOConnection();
        $this->jwtParser = new Parser();
    }

    /**
     * @return \PDO
     */
    protected function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @param Request $request
     * @return array|bool
     */
    public function checkAuth(Request $request)
    {
        $token = null;
        if (array_key_exists('authorization', $request->headers->all())) {
            $token = str_replace('Bearer ', '', $request->headers->all()['authorization'][0]);
        }

        if (!$token) {
            return ['ok' => false, 'message' => 'No authorisation token provided'];
        }

        try {
            $parsedToken = $this->jwtParser->parse($token);

            $expires = $parsedToken->getClaim('exp');

            if ($expires <= time()) {
                return ['ok' => false, 'message' => 'Your token has been expired'];
            }

            $url = $parsedToken->getClaim('iss');
            $secret = $parsedToken->getHeader('jti');

            if ($url !== getenv('URL') || $secret !== getenv('TOKEN_SECRET')) {
                return ['ok' => false, 'message' => 'Invalid token'];
            }

            $userEmail = $parsedToken->getClaim('email');
        } catch (Exception $e) {
            // todo: log this case:
            // check env variable and if PROD use logException otherwise printException
            printException($e);
            return ['ok' => false, 'message' => 'Invalid token'];
        }

        return $this->getUserByEmail($userEmail) ?
            ['ok' => true, 'message' => 'success'] :
            ['ok' => false, 'message' => 'User is not exist'];
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