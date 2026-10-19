<?php

namespace App\Interface\Api\Assessments;

interface QuizInterface
{
    // crud operations
    public function getAllQuizzes();
    public function createQuiz(array $data);
    public function getQuizById(string $id);
    public function updateQuiz(array $data, string $id);
    public function deleteQuiz(string $id);

    // additional methods
    public function getQuizQuestions(string $quizId);
    public function addQuestionToQuiz(string $quizId, array $questionData);
    public function removeQuestionFromQuiz(string $quizId, string $questionId);

    // quiz attempts
    public function startQuizAttempt(string $quizId);
    public function submitQuizAttempt(string $quizId);

    // quiz results
    public function getQuizAttempts(string $quizId);
    public function getQuizStatistics(string $quizId);
}
