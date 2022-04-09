<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Services\IceAndFire\IceAndFireMockData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BookFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->httpMocks();
    }

    /**
     * @return void
     * @test
     */
    public function can_retrieve_books_from_external_api_service()
    {
        $endpoint = route('api.books.external');

        $response = $this->getJson($endpoint);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'status', 'status_code', 'data',
        ]);
    }

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
                'authors',
                'country',
                'number_of_pages',
                'publisher',
                'release_date'
            ])
        );

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'status', 'status_code', 'data' => [
                'book' => [
                    "name",
                    "isbn",
                    "authors",
                    "country",
                    "number_of_pages",
                    "publisher",
                    "release_date",
                ]
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
                "authors" => json_encode($book_sample->authors),
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
                "name",
                "isbn",
                "authors",
                "country",
                "number_of_pages",
                "publisher",
                "release_date",
            ]
        ]);
    }

    /**
     * @return void
     * @test
     */
    public function can_update_the_details_of_a_book(): void
    {
        $book_sample = Book::factory()->create();
        $book_sample_for_update = Book::factory()->make();

        $endpoint = route('api.v1.books.update', [
            'book' => $book_sample->id,
        ]);

        $response = $this->patchJson(
            $endpoint,
            $book_sample_for_update->only([
                'name',
                'isbn',
                'authors',
                'country',
                'number_of_pages',
                'publisher',
                'release_date'
            ])
        );

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'status', 'status_code', 'message', 'data' => [
                "name",
                "isbn",
                "authors",
                "country",
                "number_of_pages",
                "publisher",
                "release_date",
            ]
        ]);

        // check to see that all info was updated
        $data_for_check = $book_sample_for_update->only([
            'name',
            'isbn',
            'authors',
            'country',
            'number_of_pages',
            'publisher',
            'release_date'
        ]);
        $data_for_check['id'] = $book_sample->id;
        $data_for_check['authors'] = json_encode($book_sample_for_update->authors);
        $data_for_check['release_date'] = Carbon::parse($book_sample_for_update->release_date);

        $this->assertDatabaseHas(
            (new Book)->getTable(),
            $data_for_check
        );
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
