<?php

use App\Http\Controllers\Api\Assessments\ExamAttemptController;
use App\Http\Controllers\Api\Assessments\ExamController;
use App\Http\Controllers\Api\Assessments\ExamQuestionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'exams', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Exam Routes Management
    Route::get('/', [ExamController::class, 'index']);
    Route::post('/', [ExamController::class, 'store']);
    Route::get('/{exam}', [ExamController::class, 'show']);
    Route::put('/{exam}', [ExamController::class, 'update']);
    Route::delete('/{exam}', [ExamController::class, 'destroy']);

    //? Exam Publish Route
    Route::post('/{exam}/publish', [ExamController::class, 'publish']);

    //? Exam Questions Management
    Route::get('/{exam}/questions', [ExamQuestionController::class, 'index']);
    Route::post('/{exam}/questions', [ExamQuestionController::class, 'store']);
    Route::delete('/{exam}/questions/{questionId}', [ExamQuestionController::class, 'destroy']);

    //? Exam management
    Route::post('/{exam}/attempts', [ExamAttemptController::class, 'start']);
    Route::post('/attempts/{attempt}/submit', [ExamAttemptController::class, 'submit']);
    Route::get('/attempts/{attempt}', [ExamAttemptController::class, 'show']);

    //? Exam Statistics
    Route::get('/{exam}/statistics', [ExamController::class, 'statistics']);
});
