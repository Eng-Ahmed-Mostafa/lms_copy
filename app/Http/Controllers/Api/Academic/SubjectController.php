<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\SubjectRequest;
use App\Interface\Api\Academic\SubjectInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    use ResponseTrait;

    protected ?SubjectInterface $subjectService;

    public function __construct(SubjectInterface $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->subjectService->index();
        return $this->finalResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectRequest $request)
    {
        $result = $this->subjectService->store($request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $result = $this->subjectService->show($slug);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectRequest $request, string $slug)
    {
        $result = $this->subjectService->update($request->validated(), $slug);
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $result = $this->subjectService->destroy($slug);
        return $this->finalResponse($result);
    }

    /**
     * Get teachers associated with a specific subject.
     */
    public function getTeachers(string $slug)
    {
        $result = $this->subjectService->getTeachers($slug);
        return $this->finalResponse($result);
    }
}
