<?php

namespace App\Http\Controllers\Api\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Courses\ChapterRequest;
use App\Http\Requests\Courses\CourseRequest;
use App\Http\Requests\Public\SearchRequest;
use App\Interface\Api\Courses\CourseInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use ResponseTrait;

    protected ?CourseInterface $courseService;

    public function __construct(CourseInterface $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * Search for courses.
     */
    public function search(SearchRequest $request)
    {
        $result = $this->courseService->search($request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->courseService->index();
        return $this->finalResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $result = $this->courseService->store($request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $result = $this->courseService->show($slug);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, string $slug)
    {
        $result = $this->courseService->update($request->validated(), $slug);
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $result = $this->courseService->destroy($slug);
        return $this->finalResponse($result);
    }

    /**
     * Get chapters of a specific course.
     */
    public function getChaptersByCourse(string $slug)
    {
        $result = $this->courseService->getChaptersByCourse($slug);
        return $this->finalResponse($result);
    }

    /**
     * Add a chapter to a specific course.
     */
    public function addChapterToCourse(ChapterRequest $request, string $slug)
    {
        $result = $this->courseService->addChapterToCourse($request->validated(), $slug);
        return $this->finalResponse($result);
    }

    /**
     * Get lessons of a specific course.
     */
    public function getLessonsByCourse(string $slug)
    {
        $result = $this->courseService->getLessonsByCourse($slug);
        return $this->finalResponse($result);
    }

    /**
     * Get students enrolled in a specific course.
     */
    public function getStudentsByCourse(string $slug)
    {
        $result = $this->courseService->getStudentsByCourse($slug);
        return $this->finalResponse($result);
    }

    /**
     * Submit a specific course for review.
     */
    public function submitCourseForReview(string $slug)
    {
        $result = $this->courseService->submitCourseForReview($slug);
        return $this->finalResponse($result);
    }

    /**
     * Publish a specific course.
     */
    public function publishCourse(string $slug)
    {
        $result = $this->courseService->publishCourse($slug);
        return $this->finalResponse($result);
    }

    /**
     * Unpublish a specific course.
     */
    public function unpublishCourse(string $slug)
    {
        $result = $this->courseService->unpublishCourse($slug);
        return $this->finalResponse($result);
    }

    /**
     * Archive a specific course.
     */
    public function archiveCourse(string $slug)
    {
        $result = $this->courseService->archiveCourse($slug);
        return $this->finalResponse($result);
    }
}
