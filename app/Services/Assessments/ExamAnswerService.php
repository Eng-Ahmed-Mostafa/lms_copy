<?php

namespace App\Services\Assessments;

use App\Interface\Api\Assessments\ExamAttemptInterface;
use App\Models\ExamAttempt;
use App\Models\Option;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExamAnswerService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private readonly ExamAttemptInterface $examAttemptRepository, private readonly ExamAttemptService $examAttemptService) {}

    public function saveAnswer(ExamAttempt $attempt, array $answers): ExamAttempt
    {
        $this->examAttemptService->ensureCanAnswer($attempt);

        return DB::transaction(function () use ($attempt, $answers) {
            $lockedAttempt = $this->examAttemptRepository->findForUpdate((int) $attempt->id);

            if (!$lockedAttempt) {
                throw ValidationException::withMessages([
                    'attempt' => 'Failed to lock the exam attempt for update.',
                ]);
            }

            $lockedAttempt->load('exam');
            $this->examAttemptService->ensureCanAnswer($lockedAttempt);

            $exam = $lockedAttempt->exam;

            if (!$exam) {
                throw ValidationException::withMessages([
                    'exam' => 'Associated exam not found for this attempt.',
                ]);
            }

            $examQuestionIds = $exam->questions()->pluck('questions.id')->map(fn ($id) => (int) $id)->all();

            foreach ($answers as $answer) {
                $questionId = (int) ($answer['question_id'] ?? 0);
                $optionId = (int) ($answer['question_option_id'] ?? 0);

                if (!in_array($questionId, $examQuestionIds, true)) {
                    throw ValidationException::withMessages([
                        'answer' => "Question ID {$questionId} does not belong to the exam.",
                    ]);
                }

                $optionBelongsToQuestion = Option::query()
                    ->whereKey($optionId)
                    ->where('question_id', $questionId)
                    ->exists();

                if (!$optionBelongsToQuestion) {
                    throw ValidationException::withMessages([
                        'answer' => "Option ID {$optionId} does not belong to Question ID {$questionId}.",
                    ]);
                }

                $this->examAttemptRepository->saveAnswers($lockedAttempt, $questionId, $optionId);
            }

            return $lockedAttempt->fresh([
                'exam',
                'examAnswers.question',
                'examAnswers.option',
            ]);
        });
    }
}
