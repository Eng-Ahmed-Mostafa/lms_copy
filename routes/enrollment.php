<?php

use App\Http\Controllers\Api\Enrollment\EnrollmentController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'enrollments', 'middleware' => ['auth:sanctum', 'verified']], function () {
    Route::post('/', [EnrollmentController::class, 'store']);
    Route::get('/{enrollment}', [EnrollmentController::class, 'show']);
    Route::post('/{enrollment}/cancel', [EnrollmentController::class, 'cancel']);
});
