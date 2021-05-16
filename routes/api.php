<?php

use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;

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

//Добавлеине корзины в базу
Route::middleware('auth')
    ->post('/cart',[CartController::class, 'create']);
//Обновление корзины в базе
Route::middleware('auth')
    ->post('/cart/update',[CartController::class, 'update']);
//Удаление продукта из заказа в базе
Route::middleware('auth')
    ->post('/cart/delete',[CartController::class, 'delete']);
//Удаление корзины
Route::middleware('auth')
    ->post('/cart/clear',[CartController::class, 'destroy']);
//Добавление заказа в базу
Route::middleware('auth')
    ->post('/order',[OrderController::class, 'create'])->name('order');
//Изменение заказа в базе
Route::middleware('permission:order-edit')
    ->patch('/order/update',[OrderController::class, 'update']);
//Обновлеине личных данных пользователя
Route::middleware('auth')
    ->patch('/user/lk/update',[UserController::class, 'updatePersonal']);
//    Удалить логи
Route::middleware('permission:logs-delete')
    ->delete('/',[LogController::class, 'destroy']);
//Действия с автором
Route::group(['prefix'=>'author'],function(){
    // Добавление автора
    Route::middleware('permission:author-create')
        ->post('/',[AuthorController::class, 'create']);
    // Изменение автора
    Route::middleware('permission:author-edit')
        ->post('/update',[AuthorController::class, 'update']);
    // Удаление автора
    Route::middleware('permission:author-delete')
        ->post('/delete',[AuthorController::class, 'destroy']);
});
//Действия с жанром
Route::group(['prefix'=>'genre'],function(){
    // Добавление жанра
    Route::middleware('permission:genre-create')
        ->post('/',[GenreController::class, 'create']);
    // Изменение жанра
    Route::middleware('permission:genre-edit')
        ->post('/update',[GenreController::class, 'update']);
    // Удаление жанра
    Route::middleware('permission:genre-delete')
        ->post('/delete',[GenreController::class, 'destroy']);
});
//Действия с издательством
Route::group(['prefix'=>'publisher'],function(){
    // Добавление издательства
    Route::middleware('permission:publisher-create')
        ->post('/',[PublisherController::class, 'create']);
    // Изменение издательства
    Route::middleware('permission:publisher-edit')
        ->post('/update',[PublisherController::class, 'update']);
    // Удаление издательства
    Route::middleware('permission:publisher-delete')
        ->post('/delete',[PublisherController::class, 'destroy']);
});
//Действия с товаром
Route::group(['prefix'=>'product'],function(){
    // Добавление товара
    Route::middleware('permission:product-create')
        ->post('/',[ProductController::class, 'create']);
    // Изменение товара
    Route::middleware('permission:product-edit')
        ->post('/update',[ProductController::class, 'update']);
    // Удаление товара
    Route::middleware('permission:product-delete')
        ->post('/delete',[ProductController::class, 'destroy']);
    // Поиск товара
    Route::middleware('permission:product-create|product-edit|product-delete')
        ->post('/search',[ProductController::class, 'search']);
});
