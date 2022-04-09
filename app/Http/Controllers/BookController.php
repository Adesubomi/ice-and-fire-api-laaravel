<?php

namespace App\Http\Controllers;

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
        try {
            $response_body = $iceAndFire->getBooks();

            if (count($response_body->object()->body) == 0) {
                return response()->failure(
                    statusCode: 404,
                    status: "not found",
                    data: [],
                );
            }

            $books_collection = Collection::make($response_body->object()->body);
            $books_response = Book::fromExternalCollection($books_collection);

            return response()->success(
                data: $books_response,
            );
        } catch (\Exception $exception) {
            return response()->failure();
        }
    }

    public function index(): JsonResponse
    {
        return response()->success(
            data: [
                'books' => Book::latest()->get(),
            ],
            message: "List of books"
        );
    }

    public function store(BookStoreRequest $request): JsonResponse
    {
        $new_book_record = Book::create($request->validated());

        return response()->success(
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
