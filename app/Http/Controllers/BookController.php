<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Models\Book;
use App\Services\IceAndFire\IceAndFireContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BookController extends Controller
{
    public function externalBooks(Request $request, IceAndFireContract $iceAndFire): JsonResponse
    {
        $query_search = $request->query('name');

        try {
            /** @var array $response_body */
            $response_body = $iceAndFire->getBooks($query_search ?? null)
                ->object();

            if (count($response_body) == 0) {
                return response()->notFound(
                    statusCode: 404,
                    status: "not found",
                    data: [],
                );
            }

            $books_collection = Collection::make($response_body);
            $books_response = Book::fromExternalCollection($books_collection);

            return response()->success(
                data: $books_response,
            );
        } catch (\Exception $exception) {
            Handler::logAnException($exception);
            return response()->failure();
        }
    }

    public function index(Request $request): JsonResponse
    {
        $query_search = $request->query('search');
        $books_query = Book::latest();

        if (!empty($query_search)) {
            $books_query = $books_query->whereYear('release_date', $query_search)
                ->orWhere('name', 'like', "%$query_search%")
                ->orWhere('country', 'like', "%$query_search%")
                ->orWhere('publisher', 'like', "%$query_search%");
        }

        return response()->success(
            data: $books_query->get(),
        );
    }

    public function store(BookStoreRequest $request): JsonResponse
    {
        $new_book_record = Book::create($request->validated());

        return response()->success(
            statusCode: 201,
            data: [
                'book' => $new_book_record,
            ],
        );
    }

    public function show(Book $book): JsonResponse
    {
        return response()->success(
            data: $book,
        );
    }

    public function update(BookUpdateRequest $request, Book $book): JsonResponse
    {
        $current_book_name = $book->name;
        $book_is_updated = $book->update($request->validated());

        if (!$book_is_updated) {
            return response()->failure();
        }

        return response()->success(
            data: $book,
            message: 'The book "'. $current_book_name .'" was updated successfully'
        );
    }

    public function destroy(Book $book): JsonResponse
    {
        $book_name = $book->name;
        $book->delete();

        return response()->success(
            data: null,
            message: 'The book "'. $book_name .'" was deleted successfully'
        );
    }
}
