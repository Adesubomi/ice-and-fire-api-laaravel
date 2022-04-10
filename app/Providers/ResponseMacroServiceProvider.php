<?php

namespace App\Providers;

use App\Exceptions\Handler;
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
            $response_body = [
                'status_code' => $statusCode ?? 200,
                'status' => 'success',
            ];

            if (!empty($message)) {
                $response_body['message'] = $message;
            }

            if (!is_null($data)) {
                $response_body['data'] = $data;
            }

            return Response::json($response_body);
        });

        Response::macro('badRequest', function () {
            return Response::json([], 400,);
        });

        Response::macro('failure', function (array $data=null, int $statusCode=500, string $status=null, string $message=null) {

            $response_body = [
                'status_code' => $statusCode,
            ];

            if (!is_null($message)) {
                $response_body['message'] = $message;
            }

            if (!is_null($status)) {
                $response_body['status'] = $status;
            }

            if (!is_null($data)) {
                $response_body['data'] = $data;
            }


            return Response::json($response_body, $statusCode);
        });
    }
}
