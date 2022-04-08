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
}
