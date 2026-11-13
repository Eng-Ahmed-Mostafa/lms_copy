<?php

use App\Http\Controllers\Api\Access\DeviceController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\Api\Auth\PasswordController;
use App\Http\Controllers\Api\Auth\TokenController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    //? Authentication Routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [PasswordController::class, 'forgotPassword']);
    Route::post('/reset-password', [PasswordController::class, 'resetPassword']);
    Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/resend-verification-email', [EmailVerificationController::class, 'resend']);

    // Protected Routes
    Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
        //? User Authentication Management Routes
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [UserController::class, 'getMeDetails']);
        Route::post('/refresh', [TokenController::class, 'refreshToken']);

        //? Device management routes
        Route::get('devices', [DeviceController::class, 'index']);
        Route::delete('devices/{deviceId}', [DeviceController::class, 'destroy']);
        Route::delete('devices', [DeviceController::class, 'destroyAll']);
    });
});
