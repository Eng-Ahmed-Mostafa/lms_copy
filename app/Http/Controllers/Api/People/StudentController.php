<?php

namespace App\Http\Controllers\Api\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\StudentRequest;
use App\Interface\Api\People\StudentInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    use ResponseTrait;

    protected ?StudentInterface $studentService;

    public function __construct(StudentInterface $studentService)
    {
        $this->studentService = $studentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->studentService->index();
        return $this->finalResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        $result = $this->studentService->store($request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->studentService->show($id);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, string $id)
    {
        $result = $this->studentService->update($id, $request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->studentService->destroy($id);
        return $this->finalResponse($result);
    }

    /**
     * Get teachers associated with a specific student.
     */
    public function getTeachers(string $id)
    {
        $result = $this->studentService->getTeachers($id);
        return $this->finalResponse($result);
    }
}
