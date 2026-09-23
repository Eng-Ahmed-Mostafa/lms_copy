<?php

use App\Http\Controllers\Api\People\TeacherController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'teachers', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Subject Routes Management
    Route::get('/', [TeacherController::class, 'index']);
    Route::post('/', [TeacherController::class, 'store']);
    Route::get('/{id}', [TeacherController::class, 'show']);
    Route::put('/{id}', [TeacherController::class, 'update']);
    Route::patch('/{id}', [TeacherController::class, 'update']);
    Route::delete('/{id}', [TeacherController::class, 'destroy']);
});
