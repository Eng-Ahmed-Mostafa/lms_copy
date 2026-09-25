<?php

namespace App\Http\Controllers\Api\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Courses\CourseCategoryRequest;
use App\Interface\Api\Courses\CourseCategoryInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    use ResponseTrait;

    protected ?CourseCategoryInterface $courseCategoryService;

    public function __construct(CourseCategoryInterface $courseCategoryService)
    {
        $this->courseCategoryService = $courseCategoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->courseCategoryService->index();
        return $this->finalResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseCategoryRequest $request)
    {
        $result = $this->courseCategoryService->store($request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $result = $this->courseCategoryService->show($slug);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseCategoryRequest $request, string $slug)
    {
        $result = $this->courseCategoryService->update($slug, $request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $result = $this->courseCategoryService->destroy($slug);
        return $this->finalResponse($result);
    }
}
