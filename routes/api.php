<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\GenreController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Добавление автора
Route::middleware('permission:author-create')
    ->post('/author',[AuthorController::class, 'create']);
// Добавление жанра
Route::middleware('permission:genre-create')
    ->post('/genre',[GenreController::class, 'create']);
// Добавление издательства
Route::middleware('permission:publisher-create')
    ->post('/publisher',[PublisherController::class, 'create']);
// Добавление товара
Route::middleware('permission:product-create')
    ->post('/product',[ProductController::class, 'create']);
