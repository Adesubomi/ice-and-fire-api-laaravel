<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('external-books', [BookController::class, 'externalBooks'])
    ->name('books.external');

Route::prefix('v1')->name('v1.')->group( function () {
    Route::resource('books', BookController::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
});
