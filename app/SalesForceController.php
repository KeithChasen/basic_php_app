<?php

namespace App;

use App\Services\SalesForceService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SalesForceController
{
    protected $salesForceService;

    public function __construct()
    {
        $this->salesForceService = new SalesForceService();
    }

    public function login()
    {
        $response = $this->salesForceService->login();

        return new Response(
            json_encode($response)
        );
    }

}