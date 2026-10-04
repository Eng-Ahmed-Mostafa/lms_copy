<?php

namespace App\Http\Controllers\Api\LerningProgress;

use App\Http\Controllers\Controller;
use App\Http\Requests\LearnignProgress\LessonProgressRequest;
use App\Interface\Api\LearningProgress\LessonProgressInterface;
use App\Models\Enrollment;
use App\Services\LearningProgress\LearningProgressService;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class LessonProgressController extends Controller
{
    use ResponseTrait;

    private ?LessonProgressInterface $lessonProgressService;
    private ?LearningProgressService $learningProgressService;

    public function __construct(LessonProgressInterface $lessonProgressService, LearningProgressService $learningProgressService)
    {
        $this->lessonProgressService = $lessonProgressService;
        $this->learningProgressService = $learningProgressService;
    }

    /**
     * Get the progress of a specific lesson for the authenticated user.
     */
    public function getLessonProgress(Enrollment $enrollment, int $lesson)
    {
        $result = $this->lessonProgressService->getLessonProgress($enrollment, $lesson);
        return $this->finalResponse($result);
    }

    /**
     * Update the progress of a specific lesson for the authenticated user.
     */
    public function updateLessonProgress(LessonProgressRequest $request, Enrollment $enrollment, int $lesson)
    {
        $result = $this->lessonProgressService->updateLessonProgress($enrollment, $lesson, $request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Mark a specific lesson as complete for the authenticated user.
     */
    public function markLessonAsComplete(Enrollment $enrollment, int $lesson)
    {
        $result = $this->learningProgressService->markLessonAsComplete($enrollment, $lesson);
        return $this->finalResponse($result);
    }
}
