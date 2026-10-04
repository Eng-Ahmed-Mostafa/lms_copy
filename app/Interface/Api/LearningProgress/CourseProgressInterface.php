<?php

namespace App\Interface\Api\LearningProgress;

use App\Models\Enrollment;

interface CourseProgressInterface
{
    public function getCourseProgress(Enrollment $enrollment, int $courseId);

    public function updateCourseProgress(Enrollment $enrollment, int $courseId);

    public function markCourseAsComplete(Enrollment $enrollment, int $courseId);
}
