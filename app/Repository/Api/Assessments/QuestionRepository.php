<?php

namespace App\Repository\Api\Assessments;

use App\Interface\Api\Assessments\QuestionInterface;
use App\Models\Question;
use App\Trait\RepositoryTrait;
use Illuminate\Support\Facades\Auth;

class QuestionRepository implements QuestionInterface
{
    use RepositoryTrait;

    // get all questions
    public function getAllQuestions()
    {
        $questions = Question::get();
        return $this->returnData(true, 'Questions retrieved successfully', 200, $questions);
    }

    // create a new question
    public function createQuestion(array $data)
    {
        $question = Question::create([
            'type' => $data['type'],
            'question_text' => $data['question_text'],
            'explanation' => $data['explanation'] ?? null,
            'points' => $data['points'],
            'difficulty' => $data['difficulty'] ?? null,
            'created_by' => Auth::id(),
            'status' => $data['status'],
        ]);
        return $this->returnData(true, 'Question created successfully', 201, $question);
    }

    // get a question by id
    public function getQuestionById(string $id)
    {
        $question = Question::find($id);
        if (!$question) {
            return $this->returnData(false, 'Question not found', 404);
        }
        return $this->returnData(true, 'Question retrieved successfully', 200, $question);
    }

    // update a question
    public function updateQuestion(string $id, array $data)
    {
        $question = Question::find($id);
        if (!$question) {
            return $this->returnData(false, 'Question not found', 404);
        }
        $question->update([
            'type' => $data['type'],
            'question_text' => $data['question_text'],
            'explanation' => $data['explanation'] ?? null,
            'points' => $data['points'],
            'difficulty' => $data['difficulty'] ?? null,
            'created_by' => Auth::id(),
            'status' => $data['status'],
        ]);
        return $this->returnData(true, 'Question updated successfully', 200, $question);
    }

    // delete a question
    public function deleteQuestion(string $id)
    {
        $question = Question::find($id);
        if (!$question) {
            return $this->returnData(false, 'Question not found', 404);
        }
        $question->delete();
        return $this->returnData(true, 'Question deleted successfully', 200);
    }

    // get options by question id
    public function getOptionsByQuestionId(string $questionId)
    {
        $question = Question::find($questionId);
        if (!$question) {
            return $this->returnData(false, 'Question not found', 404);
        }

        $options = $question->options;
        return $this->returnData(true, 'Options retrieved successfully', 200, $options);
    }

    // add an option to a question
    public function addOptionToQuestion(string $questionId, array $data)
    {
        $question = Question::find($questionId);
        if (!$question) {
            return $this->returnData(false, 'Question not found', 404);
        }
        $option = $question->options()->create([
            'option_text' => $data['option_text'],
            'is_correct' => $data['is_correct'] ?? false,
            'order' => $data['order'] ?? null,
        ]);
        return $this->returnData(true, 'Option added successfully', 201, $option);
    }
}
