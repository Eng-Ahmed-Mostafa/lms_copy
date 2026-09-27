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

    //? Course Chapters Management
    Route::get('/{slug}/chapters', [CourseController::class, 'getChaptersByCourse']);
    Route::post('/{slug}/chapters', [CourseController::class, 'addChapterToCourse']);

    //? Course Lessons Management
    Route::get('/{slug}/lessons', [CourseController::class, 'getLessonsByCourse']);

    //? Course Students Management
    Route::get('/{slug}/students', [CourseController::class, 'getStudentsByCourse']);

    //? Course Status Management
    Route::post('/{slug}/submit-review', [CourseController::class, 'submitCourseForReview']);
    Route::post('/{slug}/published', [CourseController::class, 'publishCourse']);
    Route::post('/{slug}/unpublished', [CourseController::class, 'unpublishCourse']);
    Route::post('/{slug}/archived', [CourseController::class, 'archiveCourse']);
});
