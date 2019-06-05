<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResourceController
{
    /**
     * @return Response
     *
     * method: GET
     * route: /resource
     */
    public function index()
    {
        return new Response(
            'List of items'
        );
    }

    /**
     * @param Request $request
     * @return Response
     *
     * method: POST
     * route: /resource/store
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
     * route: /resource/show/{id}
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
     * route: /resource/update/{id}
     */
    public function update(Request $request, $id)
    {
        return new Response(
            'Item updated. Item id: ' . $id
        );
    }

    /**
     * method: DELETE
     * route: /resource/destroy/{id}
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