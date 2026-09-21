<?php

use App\Http\Controllers\Api\Academic\AcademicYearController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'academic-years', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? activate and deactivate academic years
    Route::post('/{id}/activate', [AcademicYearController::class, 'activate']);
    Route::post('/{id}/deactivate', [AcademicYearController::class, 'deactivate']);

    //? get current academic year
    Route::get('/current', [AcademicYearController::class, 'getCurrentAcademicYear']);

    //? crud operations for academic years
    Route::get('/', [AcademicYearController::class, 'index']);
    Route::post('/', [AcademicYearController::class, 'store']);
    Route::get('/{id}', [AcademicYearController::class, 'show']);
    Route::put('/{id}', [AcademicYearController::class, 'update']);
    Route::delete('/{id}', [AcademicYearController::class, 'destroy']);
});
