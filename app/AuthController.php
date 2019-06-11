<?php

namespace App;

use App\Services\AuthService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    /**
     * @param Request $request
     * @return Response
     *
     * method: POST
     * route: /auth/register
     */
    public function register(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $this->authService->register($email, $password);

        $message = '';

        return new Response(
            $message
        );
    }

}