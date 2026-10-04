<?php

namespace App\Services\LearningProgress;

use App\Models\Enrollment;
use App\Repository\Api\LearningProgress\CourseProgressRepository;
use App\Repository\Api\LearningProgress\LessonProgressRepository;
use App\Trait\RepositoryTrait;
use Illuminate\Support\Facades\DB;

class LearningProgressService
{
    use RepositoryTrait;

    public function __construct(
        private ?CourseProgressRepository $courseProgressRepository,
        private ?LessonProgressRepository $lessonProgressRepository
    ) {}

    public function markLessonAsComplete(Enrollment $enrollment, int $lessonId)
    {
        return DB::transaction(function () use ($enrollment, $lessonId) {
            // Mark the lesson as complete
            $lessonProgress = $this->lessonProgressRepository->markLessonAsComplete($enrollment, $lessonId);

            $courseId = $enrollment->course_id;
            // Update the course progress based on the completed lesson
            $courseProgress = $this->courseProgressRepository->updateCourseProgress($enrollment, $courseId);

            $data = [
                'lesson_progress' => $lessonProgress['data'],
                'course_progress' => $courseProgress['data'],
            ];

            return $this->returnData(true, 'Lesson marked as complete and course progress updated successfully.', 200, $data);
        });
    }
}
