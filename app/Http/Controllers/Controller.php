<?php

namespace App\Http\Controllers;

use Exception;
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

        if ($request->has('search')) {
            $searches = $request->input('search');

            if (is_array($searches)) {
                foreach ($searches as $search) {
                    if (empty($search['values']) || !is_array($search['values'])) {
                        throw new Exception('Invalid search criteria provided.');
                    }

                    if (count($search['values']) === 1) {
                        if (!$this->validateSearchFields($search['values'][0])) {
                            throw new Exception('Invalid search criteria provided.');
                        }

                        $api->search(
                            $search['values'][0]['field'],
                            $search['values'][0]['operator'],
                            ($search['values'][0]['value'] ?? null)
                        );
                    } else {
                        $api->search($this->getSearchFieldValues($search['values']));
                    }
                }
            }
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

    protected function getSearchFieldValues(array $search_fields)
    {
        $search_field_vals = [];

        foreach ($search_fields as $field => $value) {
            if (is_int($field)) {
                if (!$this->validateSearchFields($value)) {
                    throw new Exception('Invalid search criteria provided.');
                }

                $field_vals = [
                    'field'    => $value['field'],
                    'operator' => strtoupper($value['operator']),
                ];

                if ($indexed_vals = array_filter(array_keys($value), 'is_int')) {
                    foreach (array_values($indexed_vals) as $index_val) {
                        $field_vals['value'][] = $this->getSearchFieldValues($value[$index_val]);
                    }
                } elseif (isset($value['value'])) {
                    $field_vals['value'] = $value['value'];
                }

                if (!isset($search_field_vals['field']) && !isset($search_field_vals['operator'])) {
                    $search_field_vals[] = $field_vals;
                }
            } else {
                if (!$this->validateSearchField($field)) {
                    throw new Exception('Invalid search criteria provided.');
                }

                if ($field === 'value' && $indexed_vals = array_filter(array_keys($search_fields), 'is_int')) {
                    $search_field_vals['value'] = [];

                    foreach (array_values($indexed_vals) as $index_val) {
                        $search_field_vals['value'][] = $this->getSearchFieldValues($search_fields[$index_val], true);
                    }
                } elseif (!is_int($field)) {
                    $search_field_vals[$field] = ($field === 'operator' ? strtoupper($value) : $value);
                }
            }
        }

        return $search_field_vals;
    }

    protected function validateSearchFields(array $search_fields)
    {
        if (!isset($search_fields['field']) || !isset($search_fields['operator'])) {
            return false;
        }

        if (
            !isset($search_fields['value']) &&
            !in_array(strtoupper($search_fields['operator']), $this->getSearchNullOperators())

        ) {
            return false;
        }

        return true;
    }

    protected function validateSearchField(string $field)
    {
        return in_array($field, $this->getSearchFieldKeys());
    }

    protected function getSearchFieldKeys()
    {
        return ['field', 'operator', 'value'];
    }

    protected function getSearchNullOperators()
    {
        return ['TRUE', 'FALSE', 'NULL'];
    }
}
