<?php

use App\Http\Controllers\Api\People\StudentController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'students', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Student Routes Management
    Route::get('/', [StudentController::class, 'index']);
    Route::post('/', [StudentController::class, 'store']);
    Route::get('/{id}', [StudentController::class, 'show']);
    Route::put('/{id}', [StudentController::class, 'update']);
    Route::patch('/{id}', [StudentController::class, 'update']);
    Route::delete('/{id}', [StudentController::class, 'destroy']);

    //? Additional Routes for Student
    Route::get('/{id}/courses', [StudentController::class, 'getCourses']);
    Route::get('/{id}/teachers', [StudentController::class, 'getTeachers']);
});
