<?php

namespace App\Http\Controllers\Api\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Courses\LessonRequest;
use App\Http\Requests\Courses\LessonVersionRequest;
use App\Http\Requests\Public\OrderRequest;
use App\Interface\Api\Courses\LessonInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    use ResponseTrait;

    private ?LessonInterface $lessonService;

    public function __construct(LessonInterface $lessonService)
    {
        $this->lessonService = $lessonService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->lessonService->index();
        return $this->finalResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonRequest $request)
    {
        $result = $this->lessonService->store($request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->lessonService->show($id);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LessonRequest $request, string $id)
    {
        $result = $this->lessonService->update($request->validated(), $id);
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->lessonService->destroy($id);
        return $this->finalResponse($result);
    }

    /**
     * Get the content of a specific lesson.
     */
    public function getContents(string $id)
    {
        $result = $this->lessonService->getContents($id);
        return $this->finalResponse($result);
    }

    /**
     * Get all versions of a specific lesson.
     */
    public function getVersions(string $id)
    {
        $result = $this->lessonService->getVersions($id);
        return $this->finalResponse($result);
    }

    /**
     * Create a new version for a specific lesson.
     */
    public function createVersion(LessonVersionRequest $request, string $id)
    {
        $result = $this->lessonService->createVersion($request->validated(), $id);
        return $this->finalResponse($result);
    }

    /**
     * Get a specific version of a lesson.
     */
    public function getVersion(string $id, string $versionId)
    {
        $result = $this->lessonService->getVersion($id, $versionId);
        return $this->finalResponse($result);
    }

    /**
     * Submit a lesson for approval.
     */
    public function submitForApproval(string $id)
    {
        $result = $this->lessonService->submitForApproval($id);
        return $this->finalResponse($result);
    }

    /**
     * Publish a lesson.
     */
    public function publish(string $id)
    {
        $result = $this->lessonService->publish($id);
        return $this->finalResponse($result);
    }

    /**
     * Unpublish a lesson.
     */
    public function unpublish(string $id)
    {
        $result = $this->lessonService->unpublish($id);
        return $this->finalResponse($result);
    }

    /**
     * Reorder lessons within a chapter.
     */
    public function reorder(OrderRequest $request, string $id)
    {
        $result = $this->lessonService->reorder($request->validated(), $id);
        return $this->finalResponse($result);
    }
}
