<?php

use App\Http\Controllers\Api\Academic\GradeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'grades', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Grade Routes Management
    Route::get('/', [GradeController::class, 'index']);
    Route::post('/', [GradeController::class, 'store']);
    Route::get('/{slug}', [GradeController::class, 'show']);
    Route::put('/{slug}', [GradeController::class, 'update']);
    Route::delete('/{slug}', [GradeController::class, 'destroy']);
});
