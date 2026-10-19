<?php

use App\Http\Controllers\Api\Assessments\QuizAttemptController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'quiz-attempts', 'middleware' => ['auth:sanctum', 'verified']], function () {
    // Quiz Attempt Management
    Route::get('/', [QuizAttemptController::class, 'index']);
    Route::get('/{id}', [QuizAttemptController::class, 'show']);

    // Quiz Submission Management
    Route::post('/{id}/submit', [QuizAttemptController::class, 'submit']);

    // Quiz Answers Management
    Route::get('/{id}/answers', [QuizAttemptController::class, 'getAnswers']);
    Route::post('/{id}/answers', [QuizAttemptController::class, 'submitAnswer']);

    // Quiz Results Management
    Route::get('/{id}/result', [QuizAttemptController::class, 'getResult']);
});

