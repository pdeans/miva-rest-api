<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use pdeans\Miva\Api\Manager as Api;

class AvailabilityGroupController extends Controller
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
        $this->api->func('AvailabilityGroupList_Load_Query');

        $this->api    = $this->getListLoadParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function readOne(Request $request, $id)
    {
        $this->api->func('AvailabilityGroupList_Load_Query')
            ->search('id', (int)$id)
            ->count(1);

        $this->api    = $this->getListLoadOneParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function updateBusinessAccount(Request $request, $id)
    {
        $api_response = $this->api->func('AvailabilityGroupBusinessAccount_Update_Assigned')
            ->params(array_merge(['AvailabilityGroup_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function updateCustomer(Request $request, $id)
    {
        $api_response = $this->api->func('AvailabilityGroupCustomer_Update_Assigned')
            ->params(array_merge(['AvailabilityGroup_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function updatePaymentMethod(Request $request, $id)
    {
        $api_response = $this->api->func('AvailabilityGroupPaymentMethod_Update_Assigned')
            ->params(array_merge(['AvailabilityGroup_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function updateProduct(Request $request, $id)
    {
        $api_response = $this->api->func('AvailabilityGroupProduct_Update_Assigned')
            ->params(array_merge(['AvailabilityGroup_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function updateShippingMethod(Request $request, $id)
    {
        $api_response = $this->api->func('AvailabilityGroupShippingMethod_Update_Assigned')
            ->params(array_merge(['AvailabilityGroup_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }
}
