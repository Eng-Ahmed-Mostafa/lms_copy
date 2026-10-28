<?php

namespace App\Repository\Api\Assessments;

use App\Interface\Api\Assessments\ExamInterface;
use App\Models\Exam;
use Illuminate\Pagination\LengthAwarePaginator;

class ExamRepository implements ExamInterface
{
    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return Exam::query()->with('course')->withCount('questions')
            ->when(
                isset($filters['course_id']),
                fn ($query) => $query->where('course_id', $filters['course_id'])
            )->when(
                isset($filters['status']),
                fn ($query) => $query->where('status', $filters['status'])
            )->latest()
            ->paginate((int) ($filters['per_page'] ?? 15));
    }

    public function findById(int $id, array $relations = []): ?Exam
    {
        return Exam::query()->with($relations)->find($id);
    }

    public function create(array $data): Exam
    {
        $exam = new Exam();

        $exam->fill($data);
        $exam->save();

        return $exam->fresh()->load('course');
    }

    public function update(Exam $exam, array $data): Exam
    {
        $exam->fill($data);
        $exam->save();

        return $exam->fresh()->load('course');
    }

    public function delete(Exam $exam): bool
    {
        return (bool) $exam->delete();
    }
}
