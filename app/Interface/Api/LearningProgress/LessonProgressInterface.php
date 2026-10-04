<?php

namespace App\Interface\Api\LearningProgress;

use App\Models\Enrollment;

interface LessonProgressInterface
{
    public function getLessonProgress(Enrollment $enrollment, int $lessonId);

    public function updateLessonProgress(Enrollment $enrollment, int $lessonId, array $data);

    public function markLessonAsComplete(Enrollment $enrollment, int $lessonId);
}
