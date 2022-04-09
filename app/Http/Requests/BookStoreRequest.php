<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => 'required',
            "isbn" => 'required|unique:books,isbn',
            "authors" => 'required|array',
            "country" => 'required',
            "number_of_pages" => 'required|numeric',
            "publisher" => 'required',
            "release_date" => 'required',
        ];
    }
}
