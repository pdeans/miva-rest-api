<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use pdeans\Miva\Api\Manager as Api;

class ProvisionController extends Controller
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

    public function createDomain(Request $request)
    {
        $api_response = $this->api->func('Provision_Domain')
            ->params(['xml' => $request->input('xml')])
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function createStore(Request $request)
    {
        $api_response = $this->api->func('Provision_Store')
            ->params(['xml' => $request->input('xml')])
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }
}
