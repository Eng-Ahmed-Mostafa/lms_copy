<?php

use App\Http\Controllers\Api\Assessments\OptionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'options', 'middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/{id}', [OptionController::class, 'show']);
    Route::put('/{id}', [OptionController::class, 'update']);
    Route::delete('/{id}', [OptionController::class, 'destroy']);
});
