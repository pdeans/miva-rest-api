<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use pdeans\Miva\Api\Manager as Api;

class OrderController extends Controller
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
        $this->api->func('OrderList_Load_Query');

        $this->api    = $this->getListLoadParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function readOne(Request $request, $id)
    {
        $this->api->func('OrderList_Load_Query')
            ->search('id', (int)$id)
            ->count(1);

        $this->api    = $this->getListLoadOneParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function create(Request $request)
    {
        $api_response = $this->api->func('Order_Create')
            ->params($request->all())
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function delete($id)
    {
        $api_response = $this->api->func('Order_Delete')
            ->params(['Order_ID' => (int)$id])
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function createItem(Request $request, $id)
    {
        $api_response = $this->api->func('OrderItem_Add')
            ->params(array_merge(['Order_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function updateItem(Request $request, $id, $line_id)
    {
        $api_response = $this->api->func('OrderItem_Update')
            ->params(array_merge(['Order_ID' => (int)$id, 'Line_ID' => (int)$line_id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function updateCancelItemList(Request $request, $id)
    {
        $api_response = $this->api->func('OrderItemList_Cancel')
            ->params(array_merge(['Order_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function updateDeleteItemList(Request $request, $id)
    {
        $api_response = $this->api->func('OrderItemList_Delete')
            ->params(array_merge(['Order_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function updateBackorderItemList(Request $request, $id)
    {
        $api_response = $this->api->func('OrderItemList_BackOrder')
            ->params(array_merge(['Order_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function updateCustomer(Request $request, $id)
    {
        $api_response = $this->api->func('Order_Update_Customer_Information')
            ->params(array_merge(['Order_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function readCustomFieldList(Request $request)
    {
        $this->api->func('OrderCustomFieldList_Load');

        $this->api    = $this->getListLoadParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function updateCustomFields(Request $request, $id)
    {
        $api_response = $this->api->func('OrderCustomFields_Update')
            ->params(array_merge(['Order_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }
}
