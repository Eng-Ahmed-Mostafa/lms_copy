<?php

use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user','middleware' => ['auth:sanctum', 'verified']], function () {
    //? User Management Routes
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::patch('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);

    //? User Role Management Routes
    Route::get('users/{id}/roles', [UserController::class, 'getUserRoles']);
    Route::post('users/{id}/roles', [UserController::class, 'assignRoles']);
    Route::delete('users/{id}/roles/{roleId}', [UserController::class, 'removeRole']);

    //? User Permission Management Routes
    Route::get('users/{id}/permissions', [UserController::class, 'getUserPermissions']);

    //? User Preferences Management Routes
    Route::get('users/{id}/preferences', [UserController::class, 'getUserPreferences']);
    Route::put('users/{id}/preferences', [UserController::class, 'updateUserPreferences']);

    //? User Avatar Management Routes
    Route::post('users/{id}/avatar', [UserController::class, 'uploadAvatar']);
    Route::delete('users/{id}/avatar', [UserController::class, 'deleteAvatar']);
});
