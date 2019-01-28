<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use pdeans\Miva\Api\Manager as Api;

class PriceGroupController extends Controller
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
        $this->api->func('PriceGroupList_Load_Query');

        $this->api    = $this->getListLoadParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function readOne(Request $request, $id)
    {
        $this->api->func('PriceGroupList_Load_Query')
            ->search('id', (int)$id)
            ->count(1);

        $this->api    = $this->getListLoadOneParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function readProductsList(Request $request, $id)
    {
        $params = ['PriceGroup_ID' => (int)$id];

        if ($request->has('assigned')) {
            $params['Assigned'] = (bool)(strtolower($request->input('assigned')) === 'true');
        }

        if ($request->has('unassigned')) {
            $params['Unassigned'] = (bool)(strtolower($request->input('unassigned')) === 'true');
        }

        $this->api->func('PriceGroupProductList_Load_Query')
            ->params($params);

        $this->api    = $this->getListLoadParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function updateProduct(Request $request, $id)
    {
        $api_response = $this->api->func('PriceGroupProduct_Update_Assigned')
            ->params(array_merge(['PriceGroup_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function updateCustomer(Request $request, $id)
    {
        $api_response = $this->api->func('PriceGroupCustomer_Update_Assigned')
            ->params(array_merge(['PriceGroup_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }
}
