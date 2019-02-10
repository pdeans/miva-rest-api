<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use pdeans\Miva\Api\Manager as Api;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    public function readList(Request $request)
    {
        $this->api->func('ProductList_Load_Query');

        $this->api    = $this->getListLoadParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function readOne(Request $request, $id)
    {
        $this->api->func('ProductList_Load_Query')
            ->search('id', (int)$id)
            ->count(1);

        $this->api    = $this->getListLoadOneParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function create(Request $request)
    {
        $api_response = $this->api->func('Product_Insert')
            ->params($request->all())
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function update(Request $request, $id)
    {
        $api_response = $this->api->func('Product_Update')
            ->params(array_merge(['Product_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function delete($id)
    {
        $api_response = $this->api->func('Product_Delete')
            ->params(['Product_ID' => (int)$id])
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function createImage(Request $request, $id)
    {
        $api_response = $this->api->func('ProductImage_Add')
            ->params(array_merge(['Product_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function deleteImage($id)
    {
        $api_response = $this->api->func('ProductImage_Delete')
            ->params(['ProductImage_ID' => (int)$id])
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function createInventory(Request $request)
    {
        $api_response = $this->api->func('ProductList_Adjust_Inventory')
            ->params($request->all())
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function readVariantsList($id)
    {
        $api_response = $this->api->func('ProductVariantList_Load_Product')
            ->params(['Product_ID' => $id])
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }
}
