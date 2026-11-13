<?php

use App\Http\Controllers\Api\User\PermissionController;
use App\Http\Controllers\Api\User\RoleController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'roles', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Role Routes Management
    Route::get('/', [RoleController::class, 'index']);
    Route::post('/', [RoleController::class, 'store']);
    Route::get('/{role}', [RoleController::class, 'show']);
    Route::put('/{role}', [RoleController::class, 'update']);
    Route::delete('/{role}', [RoleController::class, 'destroy']);

    //? Role Permissions Management
    Route::get('{role}/permissions', [PermissionController::class, 'getPermissionsByRole']);
    Route::post('{role}/permissions', [PermissionController::class, 'assignPermissionsToRole']);
    Route::delete('{role}/permissions/{permissionName}', [PermissionController::class, 'removePermissionFromRole']);
});
