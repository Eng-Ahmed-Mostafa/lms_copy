<?php

namespace App\Services\Assessments;

use App\Interface\Api\Assessments\ExamAttemptInterface;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExamAttemptService
{
    public function __construct(
        private readonly ExamAttemptInterface $examAttemptRepository,
        private readonly ExamGradingService $examGradingService,
    ) {}

    public function findById(int $id): ExamAttempt
    {
        $attempt = $this->examAttemptRepository->findById($id, ['exam.course', 'student', 'examAnswers.question', 'examAnswers.option']);

        if (!$attempt) {
            throw ValidationException::withMessages([
                'attempt' => 'Exam attempt not found.',
            ]);
        }

        return $attempt;
    }

    public function ensureCanAnswer(ExamAttempt $attempt): void
    {
        if ($attempt->status !== 'in_progress') {
            throw ValidationException::withMessages([
                'attempt' => 'You cannot answer questions for this exam attempt.',
            ]);
        }

        $exam = $attempt->exam;

        if (!$exam) {
            throw ValidationException::withMessages([
                'exam' => 'Associated exam not found for this attempt.',
            ]);
        }

        $now = now();

        if ($exam->start_time && $now->lt($exam->start_time)) {
            throw ValidationException::withMessages([
                'exam' => 'The exam has not started yet.',
            ]);
        }

        if ($exam->end_time && $now->gt($exam->end_time)) {
            throw ValidationException::withMessages([
                'exam' => 'The exam has already ended.',
            ]);
        }

        if ($attempt->started_at && $exam->duration) {
            $deadline = $attempt->started_at->copy()->addMinutes((int) $exam->duration);
            if ($now->gt($deadline)) {
                throw ValidationException::withMessages([
                    'exam' => 'The time for this exam attempt has expired.',
                ]);
            }
        }
    }

    public function start(int $examId, User $user): array
    {
        if (!$user->student) {
            throw ValidationException::withMessages([
                'user' => 'Only students can start an exam attempt.',
            ]);
        }

        $attempt = DB::transaction(function () use ($examId, $user) {
            $exam = Exam::query()->lockForUpdate()->withCount('questions')->findOrFail($examId);

            if ($exam->status !== 'published') {
                throw ValidationException::withMessages([
                    'exam' => 'This exam is not currently published.',
                ]);
            }

            if ($exam->start_time && now()->lt($exam->start_time)) {
                throw ValidationException::withMessages([
                    'exam' => 'The exam has not started yet.',
                ]);
            }

            if ($exam->end_time && now()->gt($exam->end_time)) {
                throw ValidationException::withMessages([
                    'exam' => 'The exam has already ended.',
                ]);
            }

            if ($exam->questions_count === 0) {
                throw ValidationException::withMessages([
                    'exam' => 'This exam has no questions and cannot be attempted.',
                ]);
            }

            $attempt = ExamAttempt::query()->where('exam_id', $exam->id)->where('student_id', $user->student->id);

            if ((clone $attempt)->where('status', 'in_progress')->exists()) {
                throw ValidationException::withMessages([
                    'attempt' => 'You already have an in-progress attempt for this exam.',
                ]);
            }

            $attemptCount = (clone $attempt)->count();

            if ($attemptCount >= $exam->attempts_allowed) {
                throw ValidationException::withMessages([
                    'attempt' => 'You have reached the maximum number of attempts for this exam.',
                ]);
            }

            return ExamAttempt::create([
                'exam_id' => $exam->id,
                'student_id' => $user->student->id,
                'attempt_number' => $attemptCount + 1,
                'status' => 'in_progress',
                'started_at' => now(),
            ]);
        });

        $exam = Exam::with('questions.options')->findOrFail($examId);

        if ($exam->randomize_questions) {
            $exam->setRelation('questions', $exam->questions->shuffle()->values());
        }

        $exam->questions->each(function ($question) {
            $question->options->each(fn ($option) => $option->makeHidden(['is_correct']));
        });

        return [
            'attempt' => $attempt,
            'exam' => $exam,
            'duration' => $exam->duration,
            'started_at' => $attempt->started_at,
            'expires_at' => $exam->duration ? $attempt->started_at->copy()->addMinutes((int) $exam->duration) : null,
        ];
    }

    public function submit(int $attemptId, User $user, array $answers = []): ExamAttempt
    {
        $attempt = ExamAttempt::with('exam')->findOrFail($attemptId);

        if (!$user->student || $attempt->student_id !== $user->student->id) {
            throw ValidationException::withMessages([
                'attempt' => 'You are not authorized to submit this exam attempt.',
            ]);
        }

        if ($attempt->status !== 'in_progress') {
            throw ValidationException::withMessages([
                'attempt' => 'You cannot submit this exam attempt.',
            ]);
        }

        return DB::transaction(function () use ($attemptId, $answers) {
            $attempt = ExamAttempt::query()->lockForUpdate()->with('exam')->findOrFail($attemptId);

            if ($attempt->status !== 'in_progress') {
                throw ValidationException::withMessages([
                    'attempt' => 'You cannot submit this exam attempt.',
                ]);
            }

            foreach ($answers as $answer) {
                $questionId = (int) $answer['question_id'] ?? null;

                $question = $attempt->exam->questions()->whereKey($questionId)->first();

                if (!$question) {
                    throw ValidationException::withMessages([
                        'answer' => "Question with ID {$questionId} does not belong to this exam.",
                    ]);
                }

                $optionId = (int) $answer['option_id'] ?? null;

                if ($optionId !== null) {
                    $ValidOption = $question->options()->whereKey($optionId)->exists();

                    if (!$ValidOption) {
                        throw ValidationException::withMessages([
                            'answer' => "Option with ID {$optionId} does not belong to question ID {$questionId}.",
                        ]);
                    }
                }

                $attempt->examAnswers()->updateOrCreate(
                    ['question_id' => $questionId],
                    [
                        'option_id' => $optionId,
                        'answer_text' => $answer['answer_text'] ?? null,
                    ]
                );
            }
            return $this->examGradingService->grade($attempt->id);
        });
    }
}
