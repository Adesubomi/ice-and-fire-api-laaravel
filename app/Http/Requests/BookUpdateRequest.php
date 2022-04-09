<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => 'sometimes',
            "isbn" => 'sometimes|unique:books,isbn',
            "author" => 'sometimes|array',
            "country" => 'sometimes',
            "number_of_pages" => 'sometimes|numeric',
            "publisher" => 'sometimes',
            "release_date" => 'sometimes',
        ];
    }
}
