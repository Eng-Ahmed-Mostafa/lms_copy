<?php

namespace App\Services\Assessments;

use App\Interface\Api\Assessments\ExamQuestionInterface;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExamQuestionService
{
    public function __construct(
        private readonly ExamQuestionInterface $examQuestions,
    ) {}

    public function index(int $examId)
    {
        $exam = Exam::findOrFail($examId);

        return $this->examQuestions->getForExam($exam);
    }

    public function attach(int $examId ,array $data): Exam
    {
        return DB::transaction(function () use ($examId, $data) {
            $exam = Exam::query()->lockForUpdate()->findOrFail($examId);

            if ($exam->attempts()->exists()) {
                throw ValidationException::withMessages([
                    'exam' => ['Cannot attach question to exam while there are attempts associated with it.'],
                ]);
            }

            $question = Question::findOrFail($data['question_id']);

            if ($exam->questions()->whereKey($question->id)->exists()) {
                throw ValidationException::withMessages([
                    'question' => ['This question is already attached to the exam.'],
                ]);
            }

            $this->examQuestions->attach($exam, $question, [
                'order' => $data['order'] ?? 0,
                'points' => $data['points'] ?? $question->points,
            ]);

            return $exam->fresh(['course', 'questions.options']);
        });
    }

    public function detach(int $examId, int $questionId): void
    {
        DB::transaction(function () use ($examId, $questionId) {
            $exam = Exam::query()->lockForUpdate()->findOrFail($examId);

            if ($exam->attempts()->exists()) {
                throw ValidationException::withMessages([
                    'exam' => ['Cannot detach question from exam while there are attempts associated with it.'],
                ]);
            }

            $question = $exam->questions()->whereKey($questionId)->first();

            if (!$question) {
                throw ValidationException::withMessages([
                    'question' => ['This question is not attached to the exam.'],
                ]);
            }

            $this->examQuestions->detach($exam, $question);
        });
    }
}
