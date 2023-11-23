<?php

use App\Http\Controllers\API\v1\AuthenticationController;
use App\Http\Controllers\API\v1\EmailVerificationController;
use App\Http\Middleware\API\GuestMiddleware;
use App\Services\SwaggerService\SwaggerService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('swagger', function () {
    return response()->file(public_path() . '/'. SwaggerService::FILENAME);
});

Route::group(['prefix' => 'v1'], function () {
    Route::get('/welcome', function () {
        return response('Hello, World');
    });
    //TODO: Unit tests for auth services
    Route::post('/email-verify/{id}', [EmailVerificationController::class, 'verify'])
        ->name('verification.verify');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('/profile', [AuthenticationController::class, 'profile'])->name('auth.profile');
        Route::post('/logout', [AuthenticationController::class, 'logout'])->name('auth.logout');
        Route::post('/resend-verification-email', [EmailVerificationController::class, 'resend'])
            ->name('email.verify.resend');

        Route::group(['middleware' => ['isEmailVerified']], function () {
            Route::get('/for-verified', function () {
                return response()->json(['message' => 'Protected from unverified users.'])
                    ->setStatusCode(200);
            });
        });
    });

    Route::middleware(GuestMiddleware::class)->group(function () {
        Route::post('/register', [AuthenticationController::class, 'register'])->name('auth.register');
        Route::post('/login', [AuthenticationController::class, 'login'])->name('auth.login');
    });
});
