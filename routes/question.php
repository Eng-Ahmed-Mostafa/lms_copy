<?php

use App\Http\Controllers\Api\Assessments\QuestionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'questions', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Quiz Routes Management
    Route::get('/', [QuestionController::class, 'index']);
    Route::post('/', [QuestionController::class, 'store']);
    Route::get('/{id}', [QuestionController::class, 'show']);
    Route::put('/{id}', [QuestionController::class, 'update']);
    Route::delete('/{id}', [QuestionController::class, 'destroy']);

    //? Option Routes Management
    Route::get('/{id}/options', [QuestionController::class, 'getOptions']);
    Route::post('/{id}/options', [QuestionController::class, 'addOption']);
});
