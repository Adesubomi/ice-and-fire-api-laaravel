<?php

namespace App\Services\IceAndFire;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\HttpFactory;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class IceAndFireMockData
{

    public static function mock(string $path): array
    {
        return match ($path) {
            '/api/books' => self::getBooks(),
            default => [],
        };
    }

    private static function getBooks(?string $bookName = null): array
    {
        return [
            'body' => [
                [
                    "url" => "https =>//www.anapioficeandfire.com/api/books/1",
                    "name" => "A Game of Thrones",
                    "isbn" => "978-0553103540",
                    "authors" => [
                        "George R. R. Martin"
                    ],
                    "numberOfPages" => 694,
                    "publisher" => "Bantam Books",
                    "country" => "United States",
                    "mediaType" => "Hardcover",
                    "released" => "1996-08-01T00:00:00",
                    "characters" => [
                        "https =>//www.anapioficeandfire.com/api/characters/2",
                    ],
                    "povCharacters" => [
                        "https =>//www.anapioficeandfire.com/api/characters/148",
                    ]
                ],
                [
                    "url" => "https =>//www.anapioficeandfire.com/api/books/2",
                    "name" => "A Clash of Kings",
                    "isbn" => "978-0553108033",
                    "authors" => ["George R. R. Martin"],
                    "numberOfPages" => 768,
                    "publisher" => "Bantam Books",
                    "country" => "United States",
                    "mediaType" => "Hardcover",
                    "released" => "1999-02-02T00:00:00",
                    "characters" => [
                        "https =>//www.anapioficeandfire.com/api/characters/2",
                    ],
                    "povCharacters" => [
                        "https =>//www.anapioficeandfire.com/api/characters/148",
                    ]
                ],
            ]
        ];
    }
}
