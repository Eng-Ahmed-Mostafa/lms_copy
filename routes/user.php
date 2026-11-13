<?php

use App\Http\Controllers\Api\User\PermissionController;
use App\Http\Controllers\Api\User\RoleController;
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
    Route::get('/{user}/roles', [RoleController::class, 'getRolesNamesByUserId']);
    Route::post('/{user}/roles', [RoleController::class, 'assignRolesToUser']);
    Route::delete('/{user}/roles/{roleId}', [RoleController::class, 'removeRolesFromUser']);

    //? User Permission Management Routes
    Route::get('/{id}/permissions', [PermissionController::class, 'getUserPermissions']);
    Route::post('/{id}/permissions', [PermissionController::class, 'assignPermissionsToUser']);
    Route::delete('/{id}/permissions/{permissionId}', [PermissionController::class, 'removePermissionFromUser']);

    //? User Preferences Management Routes
    Route::get('/{user}/preferences', [UserController::class, 'getUserPreferences']);
    Route::put('/{user}/preferences', [UserController::class, 'updateUserPreferences']);

    //? User Avatar Management Routes
    Route::post('/{user}/avatar', [UserController::class, 'uploadAvatar']);
    Route::delete('/{user}/avatar', [UserController::class, 'deleteAvatar']);
});
