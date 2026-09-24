<?php

namespace App\Http\Controllers\Api\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\TeacherRequest;
use App\Interface\Api\People\TeacherInterface;
use App\Trait\ResponseTrait;

class TeacherController extends Controller
{
    use ResponseTrait;

    protected ?TeacherInterface $teacherService;

    public function __construct(TeacherInterface $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->teacherService->index();
        return $this->finalResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeacherRequest $request)
    {
        $result = $this->teacherService->store($request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->teacherService->show($id);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeacherRequest $request, string $id)
    {
        $result = $this->teacherService->update($id, $request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->teacherService->destroy($id);
        return $this->finalResponse($result);
    }

    /**
     * Get students associated with a specific teacher.
     */
    public function getStudents(string $id)
    {
        $result = $this->teacherService->getStudents($id);
        return $this->finalResponse($result);
    }
}
