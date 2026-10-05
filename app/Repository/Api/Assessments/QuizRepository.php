<?php

namespace App\Repository\Api\Assessments;

use App\Interface\Api\Assessments\QuizInterface;
use App\Models\Quiz;
use App\Trait\RepositoryTrait;

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
}
