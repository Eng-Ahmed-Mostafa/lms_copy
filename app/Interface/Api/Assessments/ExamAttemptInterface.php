<?php

namespace App\Interface\Api\Assessments;

use App\Models\ExamAttempt;
use Illuminate\Support\Collection;

interface ExamAttemptInterface
{
    public function findById(int $id, array $relations = []);
    public function findForUpdate(int $id): ?ExamAttempt;

    public function saveAnswers(ExamAttempt $attempt, int $questionId, int $optionId): void;
    public function getAnswers(ExamAttempt $attempt): Collection;

    public function saveAttempt(ExamAttempt $attempt): bool;
}
