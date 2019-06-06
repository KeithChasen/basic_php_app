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
     * route: /
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