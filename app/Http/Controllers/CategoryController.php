<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use pdeans\Miva\Api\Manager as Api;

class CategoryController extends Controller
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
        $this->api->func('CategoryList_Load_Query');

        $this->api    = $this->getListLoadParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function readOne(Request $request, $id)
    {
        $this->api->func('CategoryList_Load_Query')
            ->search('id', (int)$id)
            ->count(1);

        $this->api    = $this->getListLoadOneParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function create(Request $request)
    {
        $api_response = $this->api->func('Category_Insert')
            ->params($request->all())
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function update(Request $request, $id)
    {
        $api_response = $this->api->func('Category_Update')
            ->params(array_merge(['Category_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function delete($id)
    {
        $api_response = $this->api->func('Category_Delete')
            ->params(['Category_ID' => (int)$id])
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function readProductsList(Request $request, $id)
    {
        $params = ['Category_ID' => (int)$id];

        if ($request->has('assigned')) {
            $params['Assigned'] = (bool)(strtolower($request->input('assigned')) === 'true');
        }

        if ($request->has('unassigned')) {
            $params['Unassigned'] = (bool)(strtolower($request->input('unassigned')) === 'true');
        }

        $this->api->func('CategoryProductList_Load_Query')
            ->params($params);

        $this->api    = $this->getListLoadParams($this->api, $request);
        $api_response = $this->api->add()->send();

        return $this->response($this->api->getLastResponse());
    }

    public function updateProduct(Request $request, $id)
    {
        $api_response = $this->api->func('CategoryProduct_Update_Assigned')
            ->params(array_merge(['Category_ID' => (int)$id], $request->all()))
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }

    public function readSubcategoriesList($id)
    {
        $api_response = $this->api->func('CategoryList_Load_Parent')
            ->params(['Parent_Id' => (int)$id])
            ->add()
            ->send();

        return $this->response($this->api->getLastResponse());
    }
}
