<?php

namespace App\Http\Controllers\Api\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Courses\LessonContentRequest;
use App\Http\Requests\Courses\LessonVersionRequest;
use App\Interface\Api\Courses\LessonVersionInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class LessonVersionController extends Controller
{
    use ResponseTrait;

    protected ?LessonVersionInterface $lessonVersionService;

    public function __construct(LessonVersionInterface $lessonVersionService)
    {
        $this->lessonVersionService = $lessonVersionService;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->lessonVersionService->show($id);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LessonVersionRequest $request, string $id)
    {
        $result = $this->lessonVersionService->update($id, $request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->lessonVersionService->destroy($id);
        return $this->finalResponse($result);
    }

    /**
     * Get the content of the specified lesson version.
     */
    public function getContents(string $id)
    {
        $result = $this->lessonVersionService->getContents($id);
        return $this->finalResponse($result);
    }

    /**
     * Add content to the specified lesson version.
     */
    public function addContents(LessonContentRequest $request, string $id)
    {
        $result = $this->lessonVersionService->addContents($id, $request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Submit the specified lesson version for review.
     */
    public function submitForReview(string $id)
    {
        $result = $this->lessonVersionService->submitForReview($id);
        return $this->finalResponse($result);
    }

    /**
     * Approve the specified lesson version.
     */
    public function approve(string $id)
    {
        $result = $this->lessonVersionService->approve($id);
        return $this->finalResponse($result);
    }

    /**
     * Reject the specified lesson version.
     */
    public function reject(string $id)
    {
        $result = $this->lessonVersionService->reject($id);
        return $this->finalResponse($result);
    }

    /**
     * Publish the specified lesson version.
     */
    public function publish(string $id)
    {
        $result = $this->lessonVersionService->publish($id);
        return $this->finalResponse($result);
    }
}
