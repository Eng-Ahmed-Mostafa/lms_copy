<?php

use App\Http\Controllers\Api\User\RoleController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'roles', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Role Routes Management
    Route::get('/', [RoleController::class, 'index']);
    Route::post('/', [RoleController::class, 'store']);
    Route::get('/{id}', [RoleController::class, 'show']);
    Route::put('/{id}', [RoleController::class, 'update']);
    Route::delete('/{id}', [RoleController::class, 'destroy']);

    //? Role Permissions Management
    Route::get('{id}/permissions', [RoleController::class, 'getPermissions']);
    Route::post('{id}/permissions', [RoleController::class, 'assignPermissions']);
    Route::delete('{id}/permissions/{permissionId}', [RoleController::class, 'removePermissions']);
});
