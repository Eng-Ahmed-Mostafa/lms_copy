<?php

namespace App\Interface\Api\Assessments;

interface ExamInterface
{
    public function index();
    public function create(array $data);
    public function show(string $id);
    public function update(array $data, string $id);
    public function destroy(string $id);
    public function getExamQuestions(string $id);
    public function addExamQuestion(array $data, string $id);
    public function removeExamQuestion(string $id, string $questionId);
    public function start(string $id);
    public function submit($request, string $id);
    public function getExamStatistics(string $id);
}
