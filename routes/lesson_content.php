<?php

use App\Http\Controllers\Api\Courses\LessonContentController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'lesson-contents', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Lesson Content Routes Management
    Route::post('/', [LessonContentController::class, 'store']);
    Route::get('/{id}', [LessonContentController::class, 'show']);
    Route::put('/{id}', [LessonContentController::class, 'update']);
    Route::delete('/{id}', [LessonContentController::class, 'destroy']);

    Route::patch('/{id}/reorder', [LessonContentController::class, 'reorder']);
});
