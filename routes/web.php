<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('shop');
})->name('shop');

Route::group(['middleware' => ['auth']], function() {
    Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});



require __DIR__.'/auth.php';
