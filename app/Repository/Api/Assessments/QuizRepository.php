<?php

namespace App\Repository\Api\Assessments;

use App\Interface\Api\Assessments\QuizInterface;
use App\Models\Quiz;
use App\Trait\RepositoryTrait;
use Illuminate\Support\Facades\Auth;

class QuizRepository implements QuizInterface
{
    use RepositoryTrait;

    // get all quizzes
    public function getAllQuizzes()
    {
        $quizzes = Quiz::get();
        return $this->returnData(true, 'Quizzes retrieved successfully.', 200, $quizzes);
    }

    // create a new quiz
    public function createQuiz(array $data)
    {
        $quiz = Quiz::create([
            'course_id' => $data['course_id'],
            'chapter_id' => $data['chapter_id'],
            'lesson_id' => $data['lesson_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'duration' => $data['duration'],
            'attempts_allowed' => $data['attempts_allowed'],
            'passing_score' => $data['passing_score'],
            'randomize_questions' => $data['randomize_questions'],
            'show_results' => $data['show_results'],
            'status' => $data['status'],
        ]);
        return $this->returnData(true, 'Quiz created successfully.', 201, $quiz);
    }

    // get a quiz by id
    public function getQuizById(string $id)
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return $this->returnData(false, 'Quiz not found.', 404, null);
        }
        return $this->returnData(true, 'Quiz retrieved successfully.', 200, $quiz);
    }

    // update a quiz
    public function updateQuiz(array $data, string $id)
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return $this->returnData(false, 'Quiz not found.', 404, null);
        }

        $quiz->update([
            'course_id' => $data['course_id'],
            'chapter_id' => $data['chapter_id'],
            'lesson_id' => $data['lesson_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'duration' => $data['duration'],
            'attempts_allowed' => $data['attempts_allowed'],
            'passing_score' => $data['passing_score'],
            'randomize_questions' => $data['randomize_questions'],
            'show_results' => $data['show_results'],
            'status' => $data['status'],
        ]);

        return $this->returnData(true, 'Quiz updated successfully.', 200, $quiz);
    }

    // delete a quiz
    public function deleteQuiz(string $id)
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return $this->returnData(false, 'Quiz not found.', 404, null);
        }

        $quiz->delete();
        return $this->returnData(true, 'Quiz deleted successfully.', 200, null);
    }

    // get all questions for a specific quiz
    public function getQuizQuestions(string $quizId)
    {
        $quiz = Quiz::find($quizId);
        if (!$quiz) {
            return $this->returnData(false, 'Quiz not found.', 404, null);
        }
        $questions = $quiz->questions;
        return $this->returnData(true, 'Questions retrieved successfully.', 200, $questions);
    }

    // add a question to a specific quiz
    public function addQuestionToQuiz(string $quizId, array $questionData)
    {
        $quiz = Quiz::find($quizId);
        if (!$quiz) {
            return $this->returnData(false, 'Quiz not found.', 404, null);
        }
        $question = $quiz->questions()->create([
            'type' => $questionData['type'],
            'question_text' => $questionData['question_text'],
            'explanation' => $questionData['explanation'] ?? null,
            'points' => $questionData['points'],
            'difficulty' => $questionData['difficulty'] ?? null,
            'created_by' => Auth::id(),
            'status' => $questionData['status'],
        ]);
        return $this->returnData(true, 'Question added successfully.', 201, $question);
    }

    // remove a question from a specific quiz
    public function removeQuestionFromQuiz(string $quizId, string $questionId)
    {
        $quiz = Quiz::find($quizId);
        if (!$quiz) {
            return $this->returnData(false, 'Quiz not found.', 404, null);
        }
        $question = $quiz->questions()->find($questionId);
        if (!$question) {
            return $this->returnData(false, 'Question not found.', 404, null);
        }
        $question->delete();
        return $this->returnData(true, 'Question removed successfully.', 200, null);
    }

    // start a quiz attempt
    public function startQuizAttempt(string $quizId)
    {
        $quiz = Quiz::find($quizId);
        if (!$quiz) {
            return $this->returnData(false, 'Quiz not found.', 404, null);
        }
        $attempt = $quiz->attempts()->create([
            'student_id' => Auth::id(),
            'attempt_number' => $quiz->attempts()->where('student_id', Auth::id())->count() + 1,
            'started_at' => now(),
            'submitted_at' => null,
            'score' => null,
            'percentage' => null,
            'passed' => null,
            'status' => 'in_progress',
        ]);
        return $this->returnData(true, 'Quiz attempt started successfully.', 201, $attempt);
    }

    // submit a quiz attempt
    public function submitQuizAttempt(string $quizId)
    {
        $quiz = Quiz::find($quizId);
        if (!$quiz) {
            return $this->returnData(false, 'Quiz not found.', 404, null);
        }
        $attempt = $quiz->attempts()->where('student_id', Auth::id())->where('status', 'in_progress')->first();
        if (!$attempt) {
            return $this->returnData(false, 'No in-progress attempt found for this quiz.', 404, null);
        }
        $attempt->update([
            'submitted_at' => now(),
            'score' => $this->calcScore($quiz),
            'percentage' => $this->calcPercentage($quiz),
            'passed' => $this->checkPass($quiz),
            'status' => 'submitted',
        ]);
        return $this->returnData(true, 'Quiz attempt submitted successfully.', 200, $attempt);
    }

    // get all attempts for a specific quiz
    public function getQuizAttempts(string $quizId)
    {
        $quiz = Quiz::find($quizId);
        if (!$quiz) {
            return $this->returnData(false, 'Quiz not found.', 404, null);
        }

        $attempts = $quiz->attempts()->where('student_id', Auth::id())->get();
        return $this->returnData(true, 'Quiz attempts retrieved successfully.', 200, $attempts);
    }

    // get quiz statistics
    public function getQuizStatistics(string $quizId)
    {
        $quiz = Quiz::find($quizId);
        if (!$quiz) {
            return $this->returnData(false, 'Quiz not found.', 404, null);
        }

        $totalAttempts = $quiz->attempts()->count();
        $averageScore = $quiz->attempts()->avg('score');
        $passCount = $quiz->attempts()->where('passed', true)->count();
        $passRate = $totalAttempts > 0 ? ($passCount / $totalAttempts) * 100 : 0;
        return $this->returnData(true, 'Quiz statistics retrieved successfully.', 200, [
            'total_attempts' => $totalAttempts,
            'average_score' => $averageScore,
            'pass_rate' => $passRate,
        ]);
    }

    //? Helper method
    public function calcScore($quiz)
    {
        return $quiz->attempts()->avg('score');
    }

    public function calcPercentage($quiz)
    {
        return $quiz->attempts()->avg('percentage');
    }

    public function checkPass($quiz)
    {
        $passCount = $quiz->attempts()->where('passed', true)->count();
        return $passCount > 0;
    }
}
