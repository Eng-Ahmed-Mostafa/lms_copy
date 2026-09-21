<?php

use App\Http\Controllers\Api\User\PermissionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'permissions', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Permission Routes Management
    Route::get('/', [PermissionController::class, 'index']);
    Route::post('/', [PermissionController::class, 'store']);
    Route::get('/{id}', [PermissionController::class, 'show']);
    Route::put('/{id}', [PermissionController::class, 'update']);
    Route::delete('/{id}', [PermissionController::class, 'destroy']);
});
