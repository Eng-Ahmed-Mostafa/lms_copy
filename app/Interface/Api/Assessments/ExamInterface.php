<?php

namespace App\Interface\Api\Assessments;

use App\Models\Exam;
use Illuminate\Pagination\LengthAwarePaginator;

interface ExamInterface
{
    public function paginate(array $filters=[]): LengthAwarePaginator;

    public function findById(int $id, array $relations=[]): ?Exam;

    public function create(array $data): Exam;

    public function update(Exam $exam, array $data): Exam;

    public function delete(Exam $exam): bool;
}
