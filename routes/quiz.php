<?php

use App\Http\Controllers\Api\Assessments\QuizController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'quizzes', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Quiz Routes Management
    Route::get('/', [QuizController::class, 'index']);
    Route::post('/', [QuizController::class, 'store']);
    Route::get('/{id}', [QuizController::class, 'show']);
    Route::put('/{id}', [QuizController::class, 'update']);
    Route::delete('/{id}', [QuizController::class, 'destroy']);

    //? Quiz Questions Management
    Route::get('/{id}/questions', [QuizController::class, 'getQuestions']);
    Route::post('/{id}/questions', [QuizController::class, 'addQuestion']);
    Route::delete('/{id}/questions/{questionId}', [QuizController::class, 'deleteQuestion']);

    //? Quiz Attempts Management
    Route::post('/{id}/start', [QuizController::class, 'startAttempt']);
    Route::post('/{id}/submit', [QuizController::class, 'submitAttempt']);

    //? Quiz Results Management
    Route::get('/{id}/attempts', [QuizController::class, 'getAttempts']);
    Route::get('/{id}/statistics', [QuizController::class, 'getStatistics']);
});
