<?php

namespace App\Repository\Api\LearningProgress;

use App\Interface\Api\LearningProgress\CourseProgressInterface;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Trait\RepositoryTrait;

class CourseProgressRepository implements CourseProgressInterface
{
    use RepositoryTrait;

    public function getCourseProgress(Enrollment $enrollment, int $courseId)
    {
        $courseProgress = $enrollment->courseProgress()->where('course_id', $courseId)->first();
        return $this->returnData(true, 'Course progress retrieved successfully.', 200, $courseProgress);
    }

    public function updateCourseProgress(Enrollment $enrollment, int $courseId)
    {
        $courseProgress = $enrollment->courseProgress()->firstOrNew([
            'course_id' => $courseId,
        ]);

        $courseProgress->student_id = $enrollment->user->student->id;

        $totalLessons = $this->getTotalLessons($courseId);
        $courseProgress->total_lessons = $totalLessons;

        $completedLessons = $this->getCompletedLessons($enrollment, $courseId);
        $courseProgress->completed_lessons = $completedLessons;

        $progressPercentage  = $this->calculateProgressPercentage($completedLessons, $totalLessons);
        $courseProgress->progress_percentage = $progressPercentage ;

        if ($completedLessons >= $totalLessons && $totalLessons > 0) {
            $courseProgress->progress_percentage = 100;
            $courseProgress->completed = true;
            $courseProgress->completed_at = now();
        } else {
            $courseProgress->completed = false;
            $courseProgress->completed_at = null;
        }

        $courseProgress->save();

        return $this->returnData(true, 'Course progress updated successfully.', 200, $courseProgress);
    }

    public function markCourseAsComplete(Enrollment $enrollment, int $courseId)
    {
        $courseProgress = $enrollment->courseProgress()->firstOrNew([
            'course_id' => $courseId,
        ]);

        $courseProgress->student_id = $enrollment->user->student->id;
        $courseProgress->progress_percentage = 100;

        $totalLessons = $this->getTotalLessons($courseId);
        $courseProgress->total_lessons = $totalLessons;
        $courseProgress->completed_lessons = $totalLessons;

        $courseProgress->completed = true;
        $courseProgress->completed_at = now();

        $courseProgress->save();

        return $this->returnData(true, 'Course marked as complete successfully.', 200, $courseProgress);
    }

    // Helper methods
    public function getTotalLessons($courseId)
    {
        $totalLessons = Lesson::whereHas('chapter', function ($query) use ($courseId) {
            $query->where('course_id', $courseId);
        })->count();

        return $totalLessons;
    }

    public function getCompletedLessons($enrollment, $courseId)
    {
        $completedLessons = $enrollment->lessonProgress()
            ->whereHas('lesson.chapter', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->where('completed', true)
            ->count();

        return $completedLessons;
    }

    public function calculateProgressPercentage($completedLessons, $totalLessons)
    {
        if ($totalLessons > 0) {
            return round(($completedLessons / $totalLessons) * 100, 2);
        }

        return 0;
    }
}
