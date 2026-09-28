<?php

namespace App\Http\Controllers\Api\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Courses\LessonContentRequest;
use App\Http\Requests\Public\OrderRequest;
use App\Interface\Api\Courses\LessonContentInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class LessonContentController extends Controller
{
    use ResponseTrait;

    protected ?LessonContentInterface $lessonContentService;

    public function __construct(LessonContentInterface $lessonContentService)
    {
        $this->lessonContentService = $lessonContentService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonContentRequest $request)
    {
        $result = $this->lessonContentService->store($request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->lessonContentService->show($id);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LessonContentRequest $request, string $id)
    {
        $result = $this->lessonContentService->update($id, $request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->lessonContentService->destroy($id);
        return $this->finalResponse($result);
    }

    /**
     * Reorder the specified resource in storage.
     */
    public function reorder(OrderRequest $request, string $id)
    {
        $result = $this->lessonContentService->reorder($id, $request->validated());
        return $this->finalResponse($result);
    }
}
