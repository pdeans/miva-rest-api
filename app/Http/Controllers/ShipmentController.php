<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use pdeans\Miva\Api\Manager as Api;

class ShipmentController extends Controller
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

    public function create(Request $request)
    {
        $api_response = $this->api->func('OrderItemList_CreateShipment')
            ->params($request->all())
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function update(Request $request)
    {
        $api_response = $this->api->func('OrderShipmentList_Update')
            ->params($request->all())
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }
}
