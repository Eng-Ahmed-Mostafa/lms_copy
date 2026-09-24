<?php

use App\Http\Controllers\Api\People\GuardianController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'guardians', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Guardian Routes Management
    Route::get('/', [GuardianController::class, 'index']);
    Route::post('/', [GuardianController::class, 'store']);
    Route::get('/{id}', [GuardianController::class, 'show']);
    Route::put('/{id}', [GuardianController::class, 'update']);
    Route::delete('/{id}', [GuardianController::class, 'destroy']);

    //? Child Management Routes
    Route::get('/{id}/children', [GuardianController::class, 'getChildren']);
    Route::post('/{id}/children', [GuardianController::class, 'addChild']);
    Route::delete('/{id}/children/{childId}', [GuardianController::class, 'removeChild']);

    //? Grades Management Routes
    Route::get('/{id}/children/{childId}/grades', [GuardianController::class, 'getGradesForChild']);
});
