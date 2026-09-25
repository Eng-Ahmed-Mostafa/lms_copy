<?php

namespace App\Http\Controllers\Api\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Courses\ChapterRequest;
use App\Interface\Api\Courses\ChapterInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    use ResponseTrait;

    protected ?ChapterInterface $chapterService;

    public function __construct(ChapterInterface $chapterService)
    {
        $this->chapterService = $chapterService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->chapterService->index();
        return $this->finalResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChapterRequest $request)
    {
        $result = $this->chapterService->store($request->all());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->chapterService->show($id);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChapterRequest $request, string $id)
    {
        $result = $this->chapterService->update($request->all(), $id);
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->chapterService->destroy($id);
        return $this->finalResponse($result);
    }
}
