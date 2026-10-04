<?php

namespace App\Http\Controllers\Api\LerningProgress;

use App\Http\Controllers\Controller;
use App\Http\Requests\LearnignProgress\CourseProgressRequest;
use App\Interface\Api\LearningProgress\CourseProgressInterface;
use App\Models\Enrollment;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class CourseProgressController extends Controller
{
    use ResponseTrait;

    private ?CourseProgressInterface $courseProgressService;

    public function __construct(CourseProgressInterface $courseProgressService)
    {
        $this->courseProgressService = $courseProgressService;
    }

    /**
     * Get the progress of a specific course for the authenticated user.
     */
    public function getCourseProgress(Enrollment $enrollment, int $course)
    {
        $result = $this->courseProgressService->getCourseProgress($enrollment, $course);
        return $this->finalResponse($result);
    }

    /**
     * Update the progress of a specific course for the authenticated user.
     */
    public function updateCourseProgress(Enrollment $enrollment, int $course)
    {
        $result = $this->courseProgressService->updateCourseProgress($enrollment, $course);
        return $this->finalResponse($result);
    }

    /**
     * Mark a specific course as complete for the authenticated user.
     */
    public function markCourseAsComplete(Enrollment $enrollment, int $course)
    {
        $result = $this->courseProgressService->markCourseAsComplete($enrollment, $course);
        return $this->finalResponse($result);
    }
}
