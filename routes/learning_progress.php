<?php

use App\Http\Controllers\Api\LerningProgress\CourseProgressController;
use App\Http\Controllers\Api\LerningProgress\LessonProgressController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'progress', 'middleware' => ['auth:sanctum', 'verified']], function () {
    // get
    Route::get('/enrollments/{enrollment}/courses/{course}', [CourseProgressController::class, 'getCourseProgress']);
    Route::get('/enrollments/{enrollment}/lessons/{lesson}', [LessonProgressController::class, 'getLessonProgress']);

    // update
    Route::put('/enrollments/{enrollment}/courses/{course}', [CourseProgressController::class, 'updateCourseProgress']);
    Route::put('/enrollments/{enrollment}/lessons/{lesson}', [LessonProgressController::class, 'updateLessonProgress']);

    // mark as complete
    Route::post('/enrollments/{enrollment}/courses/{course}/complete', [CourseProgressController::class, 'markCourseAsComplete']);
    Route::post('/enrollments/{enrollment}/lessons/{lesson}/complete', [LessonProgressController::class, 'markLessonAsComplete']);
});

