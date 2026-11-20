<?php

use App\Http\Controllers\Api\Assignments\AssignmentController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'assignments', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Assignment Routes Management
    Route::get('/', [AssignmentController::class, 'index']);
    Route::post('/', [AssignmentController::class, 'store']);
    Route::get('/{assignment}', [AssignmentController::class, 'show']);
    Route::put('/{assignment}', [AssignmentController::class, 'update']);
    Route::delete('/{assignment}', [AssignmentController::class, 'destroy']);

    //? Assignment Status Routes Management
    Route::post('/{assignment}/publish', [AssignmentController::class, 'publish']);
    Route::post('/{assignment}/close', [AssignmentController::class, 'close']);
});
