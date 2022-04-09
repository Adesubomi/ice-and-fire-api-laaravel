<?php

namespace App\Services\IceAndFire;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class IceAndFireService implements IceAndFireContract
{
    private string $baseUrl;

    public function __construct()
    {
        Http::macro('iceAndFire', function () {
            return Http::baseUrl('https://www.anapioficeandfire.com/api');
        });
    }

    public function getBooks(?string $bookName = null): Response
    {
        $uri = '/books';

        if (!empty($bookName)) {
            $uri .= '?name='.$bookName;
        }

        return Http::iceAndFire()->get($uri);
    }
}
