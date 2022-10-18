<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::group(['prefix' => 'brand', 'middleware' => 'checkWebBrand'], function () {
    Route::get('/', function () {
        return view('brand.home');
    })->name('brand.home');
    Route::resource('users', \App\Http\Controllers\Brand\UsersController::class);
    Route::resource('categories', \App\Http\Controllers\Brand\CategoriesController::class);
    Route::resource('subCategories', \App\Http\Controllers\Brand\SubCategoriesController::class);
    Route::resource('subSubCategories', \App\Http\Controllers\Brand\SubSubCategoriesController::class);
    Route::resource('products', \App\Http\Controllers\Brand\ProductsController::class);
    Route::get('deleteImage/{type}/{id}/{index}', [\App\Http\Controllers\Brand\ProductsController::class, 'deleteImage'])->name('deleteImage');
    Route::resource('collages', \App\Http\Controllers\Brand\CollagesController::class);
    Route::resource('orders', \App\Http\Controllers\Brand\OrdersController::class);
    Route::resource('transactions', \App\Http\Controllers\Brand\TransactionsController::class);

    Route::get('joinRequests/with/status/{status}', [\App\Http\Controllers\Brand\JoinRequestsController::class, 'index'])->name('joinRequests.index.status');
    Route::get('joinRequests/change/state/{id}', [\App\Http\Controllers\Brand\JoinRequestsController::class, 'update'])->name('joinRequests.test');

});
Route::group(['prefix' => 'admin'], function () {

    Route::resource('joinRequests', \App\Http\Controllers\Brand\JoinRequestsController::class);
});
