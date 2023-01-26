<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\EmailController;

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

Route::group(["middleware" => "user_auth"], function ()
{
    Route::controller(Controller::class)->group(function () {
        Route::get('get-dashboard-data', 'getDashboardData');
        
    });

    Route::controller(AccountController::class)->group(function () {
        Route::get('dashboard', 'dashboard')->name('user.dashboard');
        Route::get('logout', 'logout')->name('admin.logout');
        Route::patch('change-password', 'changePassword')->name('admin.change.password');
        
    });

    Route::group(["prefix" => "mails"], function ()
    {
        Route::controller(EmailController::class)->group(function () {
            Route::get('email-accounts', 'allEmailAccount')->name('email.account');
            Route::post('save-email-account', 'saveEmailAccount')->name('save.email.account');
            Route::get('sent-mails', 'sentMail')->name('sent.mail');
            Route::get('send-mail', 'sendMail')->name('send.mail');
            
        });
    });
});