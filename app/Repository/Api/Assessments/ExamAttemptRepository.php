<?php

namespace App\Repository\Api\Assessments;

use App\Interface\Api\Assessments\ExamAttemptInterface;
use App\Models\ExamAttempt;
use Illuminate\Support\Collection;

class ExamAttemptRepository implements ExamAttemptInterface
{
    public function findById(int $id, array $relations = [])
    {
        return ExamAttempt::query()->with($relations)->find($id);
    }

    public function findForUpdate(int $id): ?ExamAttempt
    {
        return ExamAttempt::query()->whereKey($id)->lockForUpdate()->first();
    }

    public function saveAnswers(ExamAttempt $attempt, int $questionId, int $optionId): void
    {
        $attempt->examAnswers()->updateOrCreate(
            ['question_id' => $questionId],
            [
                'question_option_id' => $optionId,
                'is_correct' => null,
                'points_earned' => null,
            ]
        );
    }

    public function getAnswers(ExamAttempt $attempt): Collection
    {
        return $attempt->examAnswers()->with(['question', 'option'])->get();
    }

    public function saveAttempt(ExamAttempt $attempt): bool
    {
        return $attempt->save();
    }
}
