<?php

namespace Tests;

use App\Services\IceAndFire\IceAndFireMockData;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function httpMocks()
    {
        Http::fake(function (Request $request) {

            $response_body = [];

            $url = parse_url($request->url());

            if ($url['host'] === 'www.anapioficeandfire.com') {
                $response_body =  IceAndFireMockData::mock($url['path']);
            }

            return Http::response(
                $response_body,
                200
            );
        });
    }
}
