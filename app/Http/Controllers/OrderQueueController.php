<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use pdeans\Miva\Api\Manager as Api;

class OrderQueueController extends Controller
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

    public function readList(Request $request, $code)
    {
        $this->api->func('Module')
            ->params([
                'Module_Code'     => 'orderworkflow',
                'Module_Function' => 'QueueOrderList_Load_Query',
                'Queue_Code'      => $code,
            ]);

        $this->api    = $this->getListLoadParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function createAcknowledge(Request $request)
    {
        $params = [
            'Module_Code'     => 'orderworkflow',
            'Module_Function' => 'OrderList_Acknowledge',
        ];

        $api_response = $this->api->func('Module')
            ->params(array_merge($params, $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }
}
