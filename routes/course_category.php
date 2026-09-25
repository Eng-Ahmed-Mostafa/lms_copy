<?php

use App\Http\Controllers\Api\Courses\CourseCategoryController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'course-categories', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Course Category Routes Management
    Route::get('/', [CourseCategoryController::class, 'index']);
    Route::post('/', [CourseCategoryController::class, 'store']);
    Route::get('/{slug}', [CourseCategoryController::class, 'show']);
    Route::put('/{slug}', [CourseCategoryController::class, 'update']);
    Route::delete('/{slug}', [CourseCategoryController::class, 'destroy']);
});
