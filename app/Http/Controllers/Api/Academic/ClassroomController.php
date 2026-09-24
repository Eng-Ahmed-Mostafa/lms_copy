<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\ClassroomRequest;
use App\Interface\Api\Academic\ClassroomInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    use ResponseTrait;

    protected ?ClassroomInterface $classroomService;

    public function __construct(ClassroomInterface $classroomService)
    {
        $this->classroomService = $classroomService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->classroomService->index();
        return $this->finalResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassroomRequest $request)
    {
        $result = $this->classroomService->store($request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->classroomService->show($id);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassroomRequest $request, string $id)
    {
        $result = $this->classroomService->update($id, $request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->classroomService->destroy($id);
        return $this->finalResponse($result);
    }

    /**
     * Get students of a specific classroom.
     */
    public function getStudents(string $id)
    {
        $result = $this->classroomService->getStudents($id);
        return $this->finalResponse($result);
    }

    /**
     * Add a student to a specific classroom.
     */
    public function addStudent(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $result = $this->classroomService->addStudent($id, $validatedData);
        return $this->finalResponse($result);
    }

    /**
     * Remove a student from a specific classroom.
     */
    public function removeStudent(string $id, string $studentId)
    {
        $result = $this->classroomService->removeStudent($id, $studentId);
        return $this->finalResponse($result);
    }
}
