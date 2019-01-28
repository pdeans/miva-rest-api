<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use pdeans\Miva\Api\Manager as Api;

class MivaApiServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Api::class, function ($app) {
            $config = [
                'url'          => env('MM_API_URL'),
                'store_code'   => env('MM_STORE_CODE'),
                'access_token' => env('MM_API_TOKEN'),
                'private_key'  => env('MM_API_KEY'),
            ];

            if (env('MM_API_HTTP_HEADERS') !== '') {
                $header_vals = array_map('trim', explode(',', env('MM_API_HTTP_HEADERS')));
                $headers     = [];

                foreach ($header_vals as $header) {
                    $header_parts = array_map('trim', explode(':', $header));
                    $headers[$header_parts[0]] = ($header_parts[1] ?? '');
                }

                $config['http_headers'] = $headers;
            }

            if (env('MM_API_HTTP_CLIENT_OPTS') !== '') {
                $client_opt_vals = array_map('trim', explode(',', env('MM_API_HTTP_CLIENT_OPTS')));
                $client_opts     = [];

                foreach ($client_opt_vals as $client_opt_val) {
                    $client_opt_parts = array_map('trim', explode(':', $client_opt_val));
                    $client_opts[(int)$client_opt_parts[0]] = ($client_opt_parts[1] ?? '');
                }

                $config['http_client'] = $client_opts;
            }

            return new Api($config);
        });
    }
}
