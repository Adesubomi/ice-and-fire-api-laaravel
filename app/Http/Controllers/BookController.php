<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
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
            data: [
                'book' => $book,
            ],
            statusCode: null,
        );
    }

    public function update(Request $request, Book $book): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Book $book
     * @return Response
     */
    public function destroy(Book $book)
    {
        //
    }
}
