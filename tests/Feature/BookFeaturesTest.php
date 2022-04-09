<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
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

    /**
     * @return void
     * @test
     */
    public function can_create_a_new_book_entry(): void
    {
        $endpoint = route('api.v1.books.store');

        $book_sample = Book::factory()
            ->make();

        $response = $this->postJson(
            $endpoint,
            $book_sample->only([
                'name',
                'isbn',
                'author',
                'country',
                'number_of_pages',
                'publisher',
                'release_date'
            ])
        );

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'status', 'status_code', 'data' => [
                'book'
            ]
        ]);

        $response->assertJsonFragment(
            $book_sample->only([
                'name',
                'isbn',
                'country'
            ])
        );

        $this->assertDatabaseHas(
            (new Book)->getTable(),
            [
                "name" => $book_sample->name,
                "isbn" => $book_sample->isbn,
                "author" => json_encode($book_sample->author),
                "country" => $book_sample->country,
                "number_of_pages" => $book_sample->number_of_pages,
                "publisher" => $book_sample->publisher,
                "release_date" => Carbon::parse($book_sample->release_date),
            ]
        );
    }

    /**
     * @return void
     * @test
     */
    public function can_view_the_details_of_a_book(): void
    {
        $book_sample = Book::factory()->create();
        $endpoint = route('api.v1.books.show', [
            'book' => $book_sample->id,
        ]);

        $response = $this->getJson($endpoint);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'status', 'status_code', 'data' => [
                'book' => [
                    "name",
                    "isbn",
                    "author",
                    "country",
                    "number_of_pages",
                    "publisher",
                    "release_date",
                ]
            ]
        ]);
    }

    /**
     * @return void
     * @test
     */
    public function can_delete_a_book()
    {
        $book_sample = Book::factory()->create();
        $endpoint = route('api.v1.books.destroy', [
            'book' => $book_sample->id,
        ]);

        $response = $this->deleteJson($endpoint);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'status', 'status_code',
        ]);

        $this->assertDatabaseMissing(
            (new Book())->getTable(),
            [
                'id' => $book_sample->id
            ]
        );
    }
}
