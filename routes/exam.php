<?php

use App\Http\Controllers\Api\Assessments\ExamController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'exams', 'middleware' => ['auth:sanctum', 'verified']], function () {
    //? Exam Routes Management
    Route::get('/', [ExamController::class, 'index']);
    Route::post('/', [ExamController::class, 'store']);
    Route::get('/{id}', [ExamController::class, 'show']);
    Route::put('/{id}', [ExamController::class, 'update']);
    Route::delete('/{id}', [ExamController::class, 'destroy']);

    //? Exam Questions Management
    Route::get('/{id}/questions', [ExamController::class, 'getExamQuestions']);
    Route::post('/{id}/questions', [ExamController::class, 'addExamQuestion']);
    Route::delete('/{id}/questions/{questionId}', [ExamController::class, 'removeExamQuestion']);

    //? Exam management
    Route::post('/{id}/start', [ExamController::class, 'startExam']);
    Route::post('/{id}/submit', [ExamController::class, 'submitExam']);

    //? Exam Statistics
    Route::get('/{id}/statistics', [ExamController::class, 'getExamStatistics']);
});
