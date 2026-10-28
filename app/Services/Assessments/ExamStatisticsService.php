<?php

namespace App\Services\Assessments;

use App\Models\Exam;
use App\Models\ExamAttempt;

class ExamStatisticsService
{
    public function get(int $examId)
    {
        $exam = Exam::with('questions')->find($examId);
        if (!$exam) {
            throw new \InvalidArgumentException('Exam not found');
        }

        $attempts = ExamAttempt::query()
            ->where('exam_id', $examId)
            ->where('status', 'submitted');

        $totalAttempts = (clone $attempts)->count();
        $passedAttempts = (clone $attempts)->where('passed', true)->count();
        $totalPoints = $exam->questions->sum(fn ($question) => (float) ($question->pivot->points ?? $question->points ?? 0));

        return [
            'exam_id' => $examId,
            'total_questions' => $exam->questions->count(),
            'total_points' => $totalPoints,
            'total_attempts' => $totalAttempts,
            'average_score' => $totalAttempts > 0 ? (float) ($attempts->avg('score') ?? 0) : 0,
            'average_percentage' => $totalAttempts > 0 ? (float) ($attempts->avg('percentage') ?? 0) : 0,
            'passed_attempts' => $passedAttempts,
            'failed_attempts' => $totalAttempts - $passedAttempts,
            'pass_rate' => $totalAttempts > 0 ? round(($passedAttempts / $totalAttempts) * 100, 2) : 0,
            'fail_rate' => $totalAttempts > 0 ? round((($totalAttempts - $passedAttempts) / $totalAttempts) * 100, 2) : 0,
        ];
    }
}
