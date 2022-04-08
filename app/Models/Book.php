<?php

namespace App\Models;

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
}
