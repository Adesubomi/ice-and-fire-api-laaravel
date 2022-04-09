<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "isbn",
        "authors",
        "country",
        "number_of_pages",
        "publisher",
        "release_date",
    ];

    protected $dates = [
        "release_date",
    ];

    /**
     * @return Attribute
     */
    protected function authors(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => json_decode($value),
            set: fn (array $value) => json_encode($value),
        );
    }

    protected function releaseDate(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => Carbon::parse($value)->format('Y-m-d'),
            set: fn (string $value) => Carbon::parse($value),
        );
    }

    public static function fromExternalCollection(Collection $books): Collection
    {
        return $books->map( function ($book) {
            return [
                "name" => $book->name,
                "isbn" => $book->isbn,
                "authors" => $book->authors,
                "number_of_pages" => $book->numberOfPages,
                "publisher" => $book->publisher,
                "country" => $book->country,
                "release_date" => Carbon::parse($book->released)
                    ->format('Y-m-d'),
            ];
        });
    }
}
