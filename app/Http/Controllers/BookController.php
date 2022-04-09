<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return response()->success(
            data: [
                'books' => Book::latest()->get(),
            ],
            statusCode: null,
            message: "List of books"
        );
    }

    public function store(BookStoreRequest $request)
    {
        $new_book_record = Book::create($request->validated());

        return response()->success(
            data: [
                'book' => $new_book_record,
            ],
            statusCode: null,
        );
    }

    public function show(Book $book): JsonResponse
    {
        return response()->success(
            data: $book,
            statusCode: null,
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
