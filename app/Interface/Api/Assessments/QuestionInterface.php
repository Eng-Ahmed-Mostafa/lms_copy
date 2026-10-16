<?php

namespace App\Interface\Api\Assessments;

interface QuestionInterface
{
    // crud operations
    public function getAllQuestions();
    public function createQuestion(array $data);
    public function getQuestionById(string $id);
    public function updateQuestion(string $id, array $data);
    public function deleteQuestion(string $id);

    // option operations
    public function getOptionsByQuestionId(string $questionId);
    public function addOptionToQuestion(string $questionId, array $data);
}
