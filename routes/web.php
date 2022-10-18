<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

Route::get('/', function () {
    return view('site.index');
})->name('index');
Auth::routes();

Route::get('/login', function () {
    return view('site.login');
})->name('login-site');
Route::get('view/login',[LoginController::class,'showLoginForm'])->name('auth.login');
Route::post('login/post', [LoginController::class,'UserLogin'])->name('auth.login.post');
