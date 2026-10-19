<?php

namespace App\Repository\Api\Assessments;

use App\Interface\Api\Assessments\QuizAttemptInterface;
use App\Models\QuizAttempt;
use App\Trait\RepositoryTrait;

class QuizAttemptRepository implements QuizAttemptInterface
{
    use RepositoryTrait;

    // get all quiz attempts
    public function getAllQuizAttempts()
    {
        $quizAttempts = QuizAttempt::all();
        return $this->returnData(true, 'Quiz Attempts retrieved successfully', 200, $quizAttempts);
    }

    // get quiz attempt by id
    public function getQuizAttemptById(string $id)
    {
        $quizAttempt = QuizAttempt::find($id);
        if (!$quizAttempt) {
            return $this->returnData(false, 'Quiz Attempt not found', 404);
        }
        return $this->returnData(true, 'Quiz Attempt retrieved successfully', 200, $quizAttempt);
    }

    // submit quiz attempt
    public function submitQuizAttempt(string $id)
    {
        $quizAttempt = QuizAttempt::find($id);
        if (!$quizAttempt) {
            return $this->returnData(false, 'Quiz Attempt not found', 404);
        }
        $quizAttempt->submitted_at = now();
        $quizAttempt->save();
        return $this->returnData(true, 'Quiz Attempt submitted successfully', 200, $quizAttempt);
    }

    // get quiz answers
    public function getQuizAnswers(string $id)
    {
        $quizAttempt = QuizAttempt::find($id);
        if (!$quizAttempt) {
            return $this->returnData(false, 'Quiz Attempt not found', 404);
        }
        $answers = $quizAttempt->answers;
        return $this->returnData(true, 'Quiz Answers retrieved successfully', 200, $answers);
    }

    // submit quiz answer
    public function submitQuizAnswer(array $data, string $id)
    {
        $quizAttempt = QuizAttempt::find($id);
        if (!$quizAttempt) {
            return $this->returnData(false, 'Quiz Attempt not found', 404);
        }
        $answer = $quizAttempt->answers()->create([
            'question_id' => $data['question_id'],
            'answer' => $data['answer'],
        ]);
        return $this->returnData(true, 'Quiz Answer submitted successfully', 200);
    }

    // get quiz result
    public function getQuizResult(string $id)
    {
        $quizAttempt = QuizAttempt::find($id);
        if (!$quizAttempt) {
            return $this->returnData(false, 'Quiz Attempt not found', 404);
        }
        $result = [
            'score' => $quizAttempt->score,
            'percentage' => $quizAttempt->percentage,
            'passed' => $quizAttempt->passed,
        ];
        return $this->returnData(true, 'Quiz Result retrieved successfully', 200, $result);
    }
}

