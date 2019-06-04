<?php

namespace App;

class ResourceController
{
    /**
     * method: GET
     * route: /resource/
     */
    public function getIndex()
    {
        return 'List of items';
    }

    /**
     * method: POST
     * route: /resource/store
     */
    public function postStore()
    {
        $name = $_POST['name'];
        return 'New item stored: User name: ' . $name;
    }

    /**
     * method: GET
     * route: /resource/show/{id}
     */
    public function getShow($id)
    {
        return 'Show item by id. Item id: ' . $id;
    }

    /**
     * method: PUT
     * route: /resource/update/{id}
     */
    public function putUpdate($id)
    {
        return 'Item updated. Item id: ' . $id;
    }

    /**
     * method: DELETE
     * route: /resource/destroy/{id}
     */
    public function deleteDestroy($id)
    {
        return 'Delete item. Item id: ' . $id;
    }

}