<?php

namespace App\Services\Assessments;

use App\Interface\Api\Assessments\ExamAttemptInterface;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExamGradingService
{
    public function __construct(private readonly ExamAttemptInterface $examAttemptRepository) {}

    public function submit(int $attemptId): ExamAttempt
    {
        return DB::transaction(function () use ($attemptId) {
            $lockedAttempt = $this->examAttemptRepository->findForUpdate($attemptId);

            if (!$lockedAttempt) {
                throw ValidationException::withMessages([
                    'attempt' => 'Failed to lock the exam attempt for update.',
                ]);
            }

            if ($lockedAttempt->status !== 'in_progress') {
                throw ValidationException::withMessages([
                    'attempt' => 'You cannot submit this exam attempt.',
                ]);
            }

            $lockedAttempt->load('exam.questions', 'examAnswers');

            $exam = $lockedAttempt->exam;

            if (!$exam) {
                throw ValidationException::withMessages([
                    'exam' => 'Associated exam not found for this attempt.',
                ]);
            }

            $questions = $exam->questions;
            $answers = $lockedAttempt->examAnswers->keyBy('question_id');

            $totalPoints = 0;
            $earnedPoints = 0;

            foreach ($questions as $question) {
                $points = $question->pivot->points ?? $question->points ?? 0;
                $totalPoints += $points;

                $answer = $answers->get($question->id);

                if(!$answer) {
                    continue;
                }

                $selectedOption = $answer->question_option_id ? $question->options()->whereKey($answer->question_option_id)->first() : null;

                $isCorrect = $selectedOption !== null && (bool) $selectedOption->is_correct;

                $pointsEarned = $isCorrect ? $points : 0;

                $answer->update([
                    'is_correct' => $isCorrect,
                    'points_earned' => $pointsEarned,
                ]);

                $earnedPoints += $pointsEarned;
            }

            $percentage = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100, 2) : 0;

            $passingScore = (float) ($exam->passing_score ?? 0);

            $lockedAttempt->score = $earnedPoints;
            $lockedAttempt->percentage = $percentage;
            $lockedAttempt->passed = $percentage >= $passingScore;
            $lockedAttempt->status = $percentage >= $passingScore ? 'passed' : 'failed';
            $lockedAttempt->submitted_at = now();

            $this->examAttemptRepository->saveAttempt($lockedAttempt);

            return $lockedAttempt->fresh([
                'exam.course',
                'student',
                'examAnswers.question',
                'examAnswers.option',
            ]);
        });
    }

    public function grade(int $attemptId): ExamAttempt
    {
        return DB::transaction(function () use ($attemptId) {
            $attempt = ExamAttempt::query()->lockForUpdate()->with('exam.questions.options', 'examAnswers.question.options')->findOrFail($attemptId);

            if($attempt->status !== 'in_progress') {
                throw ValidationException::withMessages([
                    'attempt' => 'You cannot grade this exam attempt.',
                ]);
            }

            $totalPoints = 0.0;
            $earnedPoints = 0.0;

            foreach ($attempt->exam->questions as $question) {
                $points = $question->pivot->points ?? $question->points ?? 0;
                $totalPoints += $points;

                $answer = $attempt->examAnswers->firstWhere('question_id', $question->id);

                if (!$answer || !$answer->option_id) {
                    continue;
                }

                $selectedOption = $answer->question_options->firstWhere('id', $answer->option_id);

                if ($selectedOption && $selectedOption->is_correct) {
                    $earnedPoints += $points;
                }
            }

            $percentage = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100, 2) : 0;

            $attempt->update([
                'score' => $earnedPoints,
                'percentage' => $percentage,
                'passed' => $percentage >= ($attempt->exam->passing_score ?? 0),
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            return $attempt->fresh([
                'exam',
                'examANswers.question',
            ]);
        });
    }
}
