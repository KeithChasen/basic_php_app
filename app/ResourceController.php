<?php

namespace App;

use App\Services\BasicService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class ResourceController
{
    private $basicService;

    public function __construct()
    {
        try {
            $this->basicService = new BasicService();
        } catch (Exception $e) {
            printException($e);
        }
    }

    /**
     * @param Request $request
     * @return Response
     *
     * method: GET
     * route: /
     */
    public function index(Request $request)
    {
        $authorised = $this->basicService->checkAuth($request);

        if ($authorised['ok']) {
            return new Response(
                'List of items'
            );
        }

        return new Response(
            $authorised['message']
        );
    }

    /**
     * @param Request $request
     * @return Response
     *
     * method: POST
     * route: /store
     */
    public function store(Request $request)
    {
        $name = $request->get('name');
        return new Response(
            'New item stored: User name: ' . $name
        );
    }

    /**
     * @param $id
     * @return Response
     *
     * method: GET
     * route: /show/{id}
     */
    public function show($id)
    {
        return new Response(
            'Show item by id. Item id: ' . $id
        );
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     *
     * method: PUT
     * route: /update/{id}
     */
    public function update(Request $request, $id)
    {
        $name = $request->get('name');
        return new Response(
            'Item updated. Item id: ' . $id . ' User name: ' . $name
        );
    }

    /**
     * method: DELETE
     * route: /destroy/{id}
     *
     * @param $id
     * @return string
     */
    public function destroy($id)
    {
        return new Response(
            'Delete item. Item id: ' . $id
        );
    }

}