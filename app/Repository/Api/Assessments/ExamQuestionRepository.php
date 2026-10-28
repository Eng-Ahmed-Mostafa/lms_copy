<?php

namespace App\Repository\Api\Assessments;

use App\Interface\Api\Assessments\ExamQuestionInterface;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Support\Collection;

class ExamQuestionRepository implements ExamQuestionInterface
{
    public function getForExam(Exam $exam): Collection
    {
        return $exam->questions()->with('options')->orderByPivot('order', 'asc')->get();
    }

    public function attach(Exam $exam, Question $question, array $pivotData): void
    {
        $exam->questions()->attach($question->id, $pivotData);
    }

    public function detach(Exam $exam, Question $question): void
    {
        $exam->questions()->detach($question->id);
    }
}
