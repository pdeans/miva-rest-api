<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use pdeans\Miva\Api\Manager as Api;

class CouponController extends Controller
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
        $this->api->func('CouponList_Load_Query');

        $this->api    = $this->getListLoadParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function readOne(Request $request, $id)
    {
        $this->api->func('CouponList_Load_Query')
            ->search('id', (int)$id)
            ->count(1);

        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function create(Request $request)
    {
        $api_response = $this->api->func('Coupon_Insert')
            ->params($request->all())
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function update(Request $request, $id)
    {
        $api_response = $this->api->func('Coupon_Update')
            ->params(array_merge(['Coupon_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function delete(Request $request)
    {
        $api_response = $this->api->func('CouponList_Delete')
            ->params($request->all())
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }


    public function readPriceGroupsList(Request $request, $id)
    {
        $params = ['Coupon_ID' => (int)$id];

        if ($request->has('assigned')) {
            $params['Assigned'] = (bool)(strtolower($request->input('assigned')) === 'true');
        }

        if ($request->has('unassigned')) {
            $params['Unassigned'] = (bool)(strtolower($request->input('unassigned')) === 'true');
        }

        $this->api->func('CouponPriceGroupList_Load_Query')
            ->params($params);

        $this->api    = $this->getListLoadParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function updatePriceGroup(Request $request, $id)
    {
        $api_response = $this->api->func('CouponPriceGroup_Update_Assigned')
            ->params(array_merge(['Coupon_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }
}
