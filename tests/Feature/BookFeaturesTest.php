<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookFeaturesTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @return void
     * @test
     */
    public function can_get_list_of_all_books(): void
    {
        $endpoint = route('api.v1.books.index');

        $books = Book::factory()->count(rand(2,4))->create();

        $response = $this->getJson($endpoint);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'status', 'status_code', 'data' => [
                'books'
            ]
        ]);

        $response_data = $response->getData();
        $this->assertCount($books->count(), $response_data->data->books);
    }
}
