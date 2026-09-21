<?php

use App\Http\Controllers\Api\Academic\TermController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'terms', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? activate and deactivate terms
    Route::post('/{id}/activate', [TermController::class, 'activate']);
    Route::post('/{id}/deactivate', [TermController::class, 'deactivate']);

    //? crud operations for terms
    Route::get('/', [TermController::class, 'index']);
    Route::post('/', [TermController::class, 'store']);
    Route::get('/{id}', [TermController::class, 'show']);
    Route::put('/{id}', [TermController::class, 'update']);
    Route::delete('/{id}', [TermController::class, 'destroy']);
});
