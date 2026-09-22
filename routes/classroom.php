<?php

use App\Http\Controllers\Api\Academic\ClassroomController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'classrooms', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Classroom Routes Management
    Route::get('/', [ClassroomController::class, 'index']);
    Route::post('/', [ClassroomController::class, 'store']);
    Route::get('/{id}', [ClassroomController::class, 'show']);
    Route::put('/{id}', [ClassroomController::class, 'update']);
    Route::delete('/{id}', [ClassroomController::class, 'destroy']);
});
