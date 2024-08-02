<?php

use Blume\Http\Controllers\Api\Auth\AuthenticationController;
use Blume\Http\Controllers\Api\Auth\EmailVerificationNotificationController;
use Blume\Http\Controllers\Api\Auth\PasswordForgotController;
use Blume\Http\Controllers\Api\Auth\PasswordResetController;
use Blume\Http\Controllers\Api\Auth\RegisterationController;
use Blume\Http\Controllers\Api\Auth\VerifyEmailController;
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

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('register', [RegisterationController::class, 'store'])
        ->middleware('api.auth.breakIsLogged')
        ->name('api.auth.register');

    Route::get('logged', [AuthenticationController::class, 'index'])
        ->name('api.auth.logged');

    Route::post('login', [AuthenticationController::class, 'store'])
        ->middleware('api.auth.breakIsLogged')
        ->name('api.auth.login');

    Route::post('logout', [AuthenticationController::class, 'destroy'])
        ->middleware('api.auth.breakIsNotLogged')
        ->name('api.auth.logout');

    Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
        Route::post('forgot', [PasswordForgotController::class, 'store'])
            ->middleware('api.auth.breakIsLogged')
            ->name('api.auth.password.forgot');

        Route::post('reset', [PasswordResetController::class, 'store'])
            ->middleware('api.auth.breakIsLogged')
            ->name('api.auth.password.reset');
    });

    Route::group(['prefix' => 'email', 'as' => 'email.'], function () {
        Route::group(['prefix' => 'verification', 'as' => 'verification.'], function () {
            Route::post('notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth', 'throttle:6,1'])
                ->name('api.auth.email.verification.notification');

            Route::get('{id}/{hash}', VerifyEmailController::class)
                ->middleware(['auth', 'signed', 'throttle:6,1'])
                ->name('api.auth.verification.check');
        });
    });
});
