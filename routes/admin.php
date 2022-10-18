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
Route::group(['prefix' => 'admin', 'middleware' => 'checkWebAdmin'], function () {
    Route::get('/', function () {
        return view('admin.home');
    })->name('admin.home');
    Route::resource('users', \App\Http\Controllers\Admin\UsersController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoriesController::class);
    Route::resource('subCategories', \App\Http\Controllers\Admin\SubCategoriesController::class);
    Route::resource('subSubCategories', \App\Http\Controllers\Admin\SubSubCategoriesController::class);
    Route::resource('products', \App\Http\Controllers\Admin\ProductsController::class);
    Route::get('deleteImage/{type}/{id}/{index}', [\App\Http\Controllers\Admin\ProductsController::class, 'deleteImage'])->name('deleteImage');
    Route::resource('collages', \App\Http\Controllers\Admin\CollagesController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\OrdersController::class);
    Route::resource('transactions', \App\Http\Controllers\Admin\TransactionsController::class);

    Route::get('joinRequests/with/status/{status}', [\App\Http\Controllers\Admin\JoinRequestsController::class, 'index'])->name('joinRequests.index.status');
    Route::get('joinRequests/change/state/{id}', [\App\Http\Controllers\Admin\JoinRequestsController::class, 'update'])->name('joinRequests.test');

});
Route::group(['prefix' => 'admin'], function () {

    Route::resource('joinRequests', \App\Http\Controllers\Admin\JoinRequestsController::class);
});
