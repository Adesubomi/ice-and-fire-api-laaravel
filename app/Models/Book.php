<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "isbn",
        "author",
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
    protected function author(): Attribute
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
}
