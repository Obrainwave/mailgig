<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

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
    return view('welcome');
});


Route::controller(AuthController::class)->group(function () {
    Route::match(['GET', 'POST'], 'login', 'login')->name('login');
    Route::match(['GET', 'POST'], 'request-password-reset', 'requestPasswordReset')->name('request.password.reset');
    Route::match(['GET', 'POST'], 'confirm-password-reset/{token}', 'confirmResetPassword')->name('confirm.password.reset');
});