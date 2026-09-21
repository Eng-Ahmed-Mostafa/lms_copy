<?php

use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users','middleware' => ['auth:sanctum', 'verified']], function () {
    //? User Management Routes
    Route::get('', [UserController::class, 'index']);
    Route::post('', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::patch('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);

    //? User Role Management Routes
    Route::get('/{id}/roles', [UserController::class, 'getUserRoles']);
    Route::post('/{id}/roles', [UserController::class, 'assignRoles']);
    Route::delete('/{id}/roles/{roleId}', [UserController::class, 'removeRole']);

    //? User Permission Management Routes
    Route::get('/{id}/permissions', [UserController::class, 'getUserPermissions']);

    //? User Preferences Management Routes
    Route::get('/{id}/preferences', [UserController::class, 'getUserPreferences']);
    Route::put('/{id}/preferences', [UserController::class, 'updateUserPreferences']);

    //? User Avatar Management Routes
    Route::post('/{id}/avatar', [UserController::class, 'uploadAvatar']);
    Route::delete('/{id}/avatar', [UserController::class, 'deleteAvatar']);
});
