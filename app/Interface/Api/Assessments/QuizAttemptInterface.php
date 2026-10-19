<?php

namespace App\Interface\Api\Assessments;

interface QuizAttemptInterface
{
    // Management of quiz attempts
    public function getAllQuizAttempts();
    public function getQuizAttemptById(string $id);

    // Management of quiz submission
    public function submitQuizAttempt(string $id);

    // Management of quiz answers
    public function getQuizAnswers(string $id);
    public function submitQuizAnswer(array $data, string $id);

    // Management of quiz results
    public function getQuizResult(string $id);
}
