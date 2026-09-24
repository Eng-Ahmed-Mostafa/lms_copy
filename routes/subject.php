<?php

use App\Http\Controllers\Api\Academic\SubjectController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'subjects', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Subject Routes Management
    Route::get('/', [SubjectController::class, 'index']);
    Route::post('/', [SubjectController::class, 'store']);
    Route::get('/{slug}', [SubjectController::class, 'show']);
    Route::put('/{slug}', [SubjectController::class, 'update']);
    Route::delete('/{slug}', [SubjectController::class, 'destroy']);

    //? Subject-Teacher Routes
    Route::get('/{slug}/teachers', [SubjectController::class, 'getTeachers']);
});
