<?php

namespace App\Interface\Api\Assessments;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Support\Collection;

interface ExamQuestionInterface
{
    public function getForExam(Exam $exam): Collection;

    public function attach(Exam $exam, Question $question, array $pivotData): void;

    public function detach(Exam $exam, Question $question): void;
}
