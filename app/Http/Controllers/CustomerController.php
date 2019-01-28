<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use pdeans\Miva\Api\Manager as Api;

class CustomerController extends Controller
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
        $this->api->func('CustomerList_Load_Query');

        $this->api    = $this->getListLoadParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function readOne(Request $request, $id)
    {
        $this->api->func('CustomerList_Load_Query')
            ->search('id', (int)$id)
            ->count(1);

        $this->api    = $this->getListLoadOneParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function create(Request $request)
    {
        $api_response = $this->api->func('Customer_Insert')
            ->params($request->all())
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function update(Request $request, $id)
    {
        $api_response = $this->api->func('Customer_Update')
            ->params(array_merge(['Customer_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function delete($id)
    {
        $api_response = $this->api->func('Customer_Delete')
            ->params(['Customer_ID' => (int)$id])
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function readPriceGroupList(Request $request, $id)
    {
        $params = ['Customer_ID' => (int)$id];

        if ($request->has('assigned')) {
            $params['Assigned'] = (bool)(strtolower($request->input('assigned')) === 'true');
        }

        if ($request->has('unassigned')) {
            $params['Unassigned'] = (bool)(strtolower($request->input('unassigned')) === 'true');
        }

        $this->api->func('CustomerPriceGroupList_Load_Query')
            ->params($params);

        $this->api    = $this->getListLoadParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function readAddressList(Request $request, $id)
    {
        $this->api->func('CustomerAddressList_Load_Query')
            ->params(['Customer_ID' => (int)$id]);

        $this->api    = $this->getListLoadParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }
}
