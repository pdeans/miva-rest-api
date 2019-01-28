<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use pdeans\Miva\Api\Manager as Api;

class PaymentController extends Controller
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

    public function updateCapture(Request $request, $id)
    {
        $api_response = $this->api->func('OrderPayment_Capture')
            ->params(array_merge(['OrderPayment_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function updateRefund(Request $request, $id)
    {
        $api_response = $this->api->func('OrderPayment_Refund')
            ->params(array_merge(['OrderPayment_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function updateVoid(Request $request, $id)
    {
        $api_response = $this->api->func('OrderPayment_VOID')
            ->params(array_merge(['OrderPayment_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }
}
