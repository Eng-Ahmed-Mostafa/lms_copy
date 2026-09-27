<?php

use App\Http\Controllers\Api\Courses\LessonVersionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'lesson-versions', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Lesson Version Routes Management
    Route::get('/{id}', [LessonVersionController::class, 'show']);
    Route::put('/{id}', [LessonVersionController::class, 'update']);
    Route::delete('/{id}', [LessonVersionController::class, 'destroy']);

    //? Lesson Version Workflow Management
    Route::post('/{id}/submit', [LessonVersionController::class, 'submitForReview']);
    Route::post('/{id}/approve', [LessonVersionController::class, 'approve']);
    Route::post('/{id}/reject', [LessonVersionController::class, 'reject']);
    Route::post('/{id}/publish', [LessonVersionController::class, 'publish']);
});
