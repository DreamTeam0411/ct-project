<?php

use App\Http\Controllers\API\v1\Admin\AdminCategoryController;
use App\Http\Controllers\API\v1\Admin\AdminCityController;
use App\Http\Controllers\API\v1\Admin\AdminServiceController;
use App\Http\Controllers\API\v1\Authentication\AuthenticationController;
use App\Http\Controllers\API\v1\Authentication\EmailVerificationController;
use App\Http\Controllers\API\v1\Authentication\PasswordController;
use App\Http\Controllers\API\v1\HomePageController;
use App\Http\Middleware\API\GuestMiddleware;
use App\Services\Swagger\SwaggerService;
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
    Route::get('/homepage', [HomePageController::class, 'index'])->name('title.page');
    //TODO: Unit tests for auth services
    Route::get('/email-verify/{id}', [EmailVerificationController::class, 'verify'])
        ->name('verification.verify');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('/profile', [AuthenticationController::class, 'profile'])->name('auth.profile');
        Route::post('/logout', [AuthenticationController::class, 'logout'])->name('auth.logout');
        Route::post('/resend-verification-email', [EmailVerificationController::class, 'resend'])
            ->name('verification.resend');

        Route::group(['middleware' => ['isEmailVerified']], function () {
            Route::get('/for-verified', function () {
                return response()->json(['message' => 'Protected from unverified users.'])
                    ->setStatusCode(200);
            });
        });

        Route::group(['prefix' => 'admin', 'middleware' => ['isAuthUserAdmin']], function () {
            Route::apiResource('cities', AdminCityController::class);
            Route::apiResource('categories', AdminCategoryController::class);
            Route::apiResource('services', AdminServiceController::class);
        });
    });

    Route::middleware(GuestMiddleware::class)->group(function () {
        Route::post('/register', [AuthenticationController::class, 'register'])->name('auth.register');
        Route::post('/login', [AuthenticationController::class, 'login'])->name('auth.login');
        Route::post('/reset-password', [PasswordController::class, 'resetPassword'])
            ->name('auth.password.reset');
        Route::post('/change-password/{token}', [PasswordController::class, 'changePassword'])
            ->name('auth.password.change');
    });
});
