<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\CollagesController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\SlidersController;
use App\Http\Controllers\Api\SubCategoriesController;
use App\Http\Controllers\Api\SubSubCategoriesController;
use Illuminate\Http\Request;
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
Route::resource('categories', CategoriesController::class);
Route::resource('products', ProductsController::class);

Route::resource('subCategories', SubCategoriesController::class);
Route::get('indexAjax', [SubCategoriesController::class,'indexAjax'])->name('indexAjax');

Route::resource('subSubCategories', SubSubCategoriesController::class);
Route::resource('collages', CollagesController::class);
Route::resource('sliders', SlidersController::class);


Route::group(['prefix' => 'users'], function () {
    Route::post('login/{type}', [AuthController::class, 'login']);
    Route::post('register/{type}', [AuthController::class, 'register']);
    Route::get('logout', [AuthController::class, 'logout']);

});
Route::group(['middleware' => 'checkAuth'], function () {
    Route::get('products/wishlist/{action}', [ProductsController::class, 'wishlist']);
    Route::get('productsWishlist', [ProductsController::class, 'wishlistList']);
    Route::post('users/update/profile/{type}', [AuthController::class, 'updateProfile']);
    Route::get('users/profile/{type}/{profile}',[AuthController::class, 'profile']);

    Route::resource('carts', \App\Http\Controllers\Api\CartController::class);
    Route::resource('orders', \App\Http\Controllers\Api\OrdersController::class);
    Route::get('orders/track/{order_id}', [\App\Http\Controllers\Api\OrdersController::class, 'track']);
});
