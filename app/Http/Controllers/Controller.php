<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use pdeans\Miva\Api\Manager as Api;
use Zend\Diactoros\Response;

class Controller extends BaseController
{
    protected $api = null;
    protected $response_headers = ['Content-Type' => 'application/json'];

    public function response(Response $response)
    {
        return response((string)$response->getBody(), $response->getStatusCode())
            ->withHeaders($this->response_headers);
    }

    public function getListLoadParams(Api $api, Request $request)
    {
        if ($request->has('count')) {
            $api->count((int)$request->input('count'));
        }

        if ($request->has('offset')) {
            $api->offset((int)$request->input('offset'));
        }

        if ($request->has('sort')) {
            $api->sort($request->input('sort'));
        }

        if ($request->has('odc')) {
            $api->odc(explode(',', $request->input('odc')));
        }

        if ($request->has('show')) {
            $api->show($request->input('show'));
        }

        return $api;
    }

    public function getListLoadOneParams(Api $api, Request $request)
    {
        if ($request->has('odc')) {
            $api->odc(explode(',', $request->input('odc')));
        }

        return $api;
    }
}
