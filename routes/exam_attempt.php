<?php

use App\Http\Controllers\Api\Assessments\ExamAttemptController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'exam-attempts', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Exam Attempt Routes Management
    Route::get('/{attempt}', [ExamAttemptController::class, 'show']);
    Route::post('/{attempt}/submit', [ExamAttemptController::class, 'submit']);

    //? Exam Attempt Answers Management
    Route::get('/{attempt}/answers', [ExamAttemptController::class, 'getAnswers']);
    Route::post('/{attempt}/answers', [ExamAttemptController::class, 'submitAnswers']);

    //? Exam Attempt Results Management
    Route::get('/{attempt}/results', [ExamAttemptController::class, 'getResults']);
});
