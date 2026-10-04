<?php

namespace App\Repository\Api\LearningProgress;

use App\Interface\Api\LearningProgress\LessonProgressInterface;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use App\Trait\RepositoryTrait;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;

class LessonProgressRepository implements LessonProgressInterface
{
    use RepositoryTrait;

    public function getLessonProgress(Enrollment $enrollment, int $lessonId)
    {
        $lessonProgress = LessonProgress::where('enrollment_id', $enrollment->id)->where('lesson_id', $lessonId)->where('student_id', Auth::user()->student->id)->first();
        return $this->returnData(true, 'Lesson progress retrieved successfully.', 200, $lessonProgress);
    }

    public function updateLessonProgress(Enrollment $enrollment, int $lessonId, array $data)
    {
        $studentId = Auth::user()->student->id;

        $lessonProgress = LessonProgress::firstOrNew([
            'enrollment_id' => $enrollment->id,
            'lesson_id' => $lessonId,
            'student_id' => $studentId,
        ]);

        $lessonProgress->progress_percentage = $this->calcProgressPercentage($enrollment, $lessonId);
        $lessonProgress->watch_seconds = $data['watch_seconds'] ?? ($lessonProgress->watch_seconds ?? 0);
        $lessonProgress->last_position = $data['last_position'] ?? ($lessonProgress->last_position ?? 0);

        $lessonProgress->save();

        return $this->returnData(true, 'Lesson progress updated successfully.', 200, $lessonProgress);
    }

    public function markLessonAsComplete(Enrollment $enrollment, int $lessonId)
    {
        $studentId = Auth::user()->student->id;

        $lessonProgress = LessonProgress::firstOrNew([
            'enrollment_id' => $enrollment->id,
            'lesson_id' => $lessonId,
            'student_id' => $studentId,
        ]);

        $lessonProgress->progress_percentage = 100;
        $lessonProgress->completed = true;
        $lessonProgress->completed_at = now();

        $lessonProgress->save();

        return $this->returnData(true, 'Lesson marked as complete.', 200, $lessonProgress);
    }

    public function calcProgressPercentage(Enrollment $enrollment, int $lessonId): float
    {
        $lessonDuration = $enrollment->course->lessons()->where('lessons.id', $lessonId)->value('lessons.duration');

        $lessonProgress = LessonProgress::where('enrollment_id', $enrollment->id)
            ->where('lesson_id', $lessonId)
            ->where('student_id', Auth::user()->student->id)
            ->first();

        if (!$lessonProgress || $lessonDuration <= 0) {
            return 0.0;
        }

        return min(100.0, ($lessonProgress->watch_seconds / $lessonDuration) * 100);
    }
}
