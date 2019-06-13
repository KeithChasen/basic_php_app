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
     * @return bool
     */
    public function checkAuth(Request $request)
    {
        $token = null;
        if (array_key_exists('authorization', $request->headers->all())) {
            $token = str_replace('Bearer ', '', $request->headers->all()['authorization'][0]);
        }

        if (!$token) {
            return false;
        }

        try {
            $parsedToken = $this->jwtParser->parse($token);

            //todo: check
            // 1 expired or not
            // 2 issuedBy(getenv('URL'))
            // 3 permittedFor(getenv('URL'))
            // 4 identifiedBy(getenv('TOKEN_SECRET'), true)

            $userEmail = $parsedToken->getClaim('email');
        } catch (Exception $e) {
            // todo: log this case:
            // check env variable and if PROD use logException otherwise printException
            printException($e);
            return false;
        }

        return $this->getUserByEmail($userEmail) ? true : false;
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