<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/', [ShopController::class, 'shop'])->name('shop.shop');
Route::post('/shop/', [ShopController::class, 'filter'])->name('shop.filter');

Route::get('/shop/author/{id}', [ShopController::class, 'author'])->name('shop.author');
Route::get('/shop/publisher/{id}', [ShopController::class, 'publisher'])->name('shop.publisher');
Route::get('/shop/limit/{id}', [ShopController::class, 'limit'])->name('shop.limit');
Route::get('/shop/genre/{id}', [ShopController::class, 'genre'])->name('shop.genre');
Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::group(['middleware' => ['auth']], function() {
    Route::get('user/lk', [UserController::class, 'lk'])->name('lk');
    Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::middleware('permission:order-edit')->get('orders', [OrderController::class, 'index'])->name('orders');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';

Route::get('/{id}', [ShopController::class, 'show'])->name('shop.show');
