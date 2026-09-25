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
});
