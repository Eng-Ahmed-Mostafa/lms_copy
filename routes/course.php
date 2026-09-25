<?php

use App\Http\Controllers\Api\Courses\CourseController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'courses', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Course Routes Management
    Route::get('/', [CourseController::class, 'index']);
    Route::post('/', [CourseController::class, 'store']);
    Route::get('/{slug}', [CourseController::class, 'show']);
    Route::put('/{slug}', [CourseController::class, 'update']);
    Route::patch('/{slug}', [CourseController::class, 'update']);
    Route::delete('/{slug}', [CourseController::class, 'destroy']);

    Route::get('/{slug}/students', [CourseController::class, 'getStudentsByCourse']);

    Route::post('/{slug}/published', [CourseController::class, 'publishCourse']);
    Route::post('/{slug}/unpublished', [CourseController::class, 'unpublishCourse']);
    Route::post('/{slug}/archived', [CourseController::class, 'archiveCourse']);
});
