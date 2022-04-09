<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function (mixed $data, int $statusCode = null, string $message="") {
            $payload = [
                'status_code' => $statusCode ?? 200,
                'status' => 'success',
            ];

            if (!empty($message)) {
                $payload['message'] = $message;
            }

            if (!is_null($data)) {
                $payload['data'] = $data;
            }

            return Response::json($payload);
        });

        Response::macro('badRequest', function () {
            return Response::json([], 400,);
        });

        Response::macro('failure', function (array $data=null, int $statusCode=500, string $status=null, string $message=null) {

            $response_body = [
                'status_code' => $statusCode,
            ];

            if (!is_null($message)) {
                $payload['message'] = $message;
            }

            if (!is_null($data)) {
                $payload['data'] = $data;
            }


            return Response::json($response_body, $statusCode);
        });
    }
}
