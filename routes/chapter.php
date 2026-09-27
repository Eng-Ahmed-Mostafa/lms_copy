<?php

use App\Http\Controllers\Api\Courses\ChapterController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'chapters', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Chapter Routes Management
    Route::get('/', [ChapterController::class, 'index']);
    Route::post('/', [ChapterController::class, 'store']);
    Route::get('/{id}', [ChapterController::class, 'show']);
    Route::put('/{id}', [ChapterController::class, 'update']);
    Route::delete('/{id}', [ChapterController::class, 'destroy']);

    //? Chapter Lessons Management
    Route::get('/{id}/lessons', [ChapterController::class, 'getLessons']);
    Route::post('/{id}/lessons', [ChapterController::class, 'addLesson']);

    //? Reorder Chapters
    Route::post('/{id}/reorder', [ChapterController::class, 'reorder']);
});
