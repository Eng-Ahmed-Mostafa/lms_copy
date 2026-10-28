<?php

namespace App\Services\Assessments;

use App\Interface\Api\Assessments\ExamInterface;
use App\Models\Exam;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExamService
{
    public function __construct(
        private readonly ExamInterface $exams,
    ) {}

    public function index(array $filters = [])
    {
        return $this->exams->paginate($filters);
    }

    public function show(int $id)
    {
        return $this->exams->findById($id, ['course', 'questions'])
            ?? throw (new ModelNotFoundException())->setModel(Exam::class, $id);
    }

    public function create(array $data)
    {
        return $this->exams->create($data);
    }

    public function update(int $id, array $data): Exam
    {
        return DB::transaction(function () use ($id, $data) {
            $exam = Exam::query()->lockForUpdate()->findOrFail($id);

            if ($exam->attempts()->where('status', 'in_progress')->exists()) {
                throw ValidationException::withMessages([
                    'exam' => ['Cannot update exam while there are in-progress attempts.'],
                ]);
            }

            return $this->exams->update($exam, $data);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $exam = Exam::query()->lockForUpdate()->findOrFail($id);

            if ($exam->attempts()->exists()) {
                throw ValidationException::withMessages([
                    'exam' => ['Cannot delete exam while there are attempts associated with it.'],
                ]);
            }

            return $this->exams->delete($exam);
        });
    }

    public function publish(int $id): Exam
    {
        return DB::transaction(function () use ($id) {
            $exam = Exam::query()->lockForUpdate()->findOrFail($id);

            if ($exam->status === 'published') {
                throw ValidationException::withMessages([
                    'exam' => ['Exam is already published.'],
                ]);
            }

            $exam->status = 'published';
            $exam->save();

            return $exam;
        });
    }
}
