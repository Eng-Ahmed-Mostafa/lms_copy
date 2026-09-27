<?php

use App\Http\Controllers\Api\Courses\LessonController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'lessons', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Lesson Routes Management
    Route::get('/', [LessonController::class, 'index']);
    Route::post('/', [LessonController::class, 'store']);
    Route::get('/{id}', [LessonController::class, 'show']);
    Route::put('/{id}', [LessonController::class, 'update']);
    Route::delete('/{id}', [LessonController::class, 'destroy']);

    //? Lesson Content Management
    Route::get('/{id}/contents', [LessonController::class, 'getContents']);

    //? Lesson Version Management
    Route::get('/{id}/versions', [LessonController::class, 'getVersions']);
    Route::post('/{id}/versions', [LessonController::class, 'createVersion']);
    Route::get('/{id}/versions/{versionId}', [LessonController::class, 'getVersion']);

    //? Additional Lesson Actions
    Route::post('/{id}/submit', [LessonController::class, 'submitForApproval']);
    Route::post('/{id}/publish', [LessonController::class, 'publish']);
    Route::post('/{id}/unpublish', [LessonController::class, 'unpublish']);

    //? Reorder Lessons
    Route::post('/{id}/reorder', [LessonController::class, 'reorder']);
});
