<?php

namespace App\Repository\Api\Academic;

use App\Interface\Api\Academic\ClassroomInterface;
use App\Models\Classroom;
use App\Models\Student;
use App\Trait\RepositoryTrait;

class ClassroomRepository implements ClassroomInterface
{
    use RepositoryTrait;

    // get all classrooms with their grades and academic years
    public function index()
    {
        $classrooms = Classroom::with(['grade', 'academicYear'])->get();
        return $this->returnData(true, 'Classrooms retrieved successfully', 200, $classrooms);
    }

    // store a new classroom
    public function store(array $data)
    {
        $classroom = Classroom::create([
            'name' => $data['name'],
            'code' => $data['code'],
            'grade_id' => $data['grade_id'],
            'academic_year_id' => $data['academic_year_id'],
            'capacity' => $data['capacity'] ?? null,
            'status' => $data['status'] ?? 'active',
        ]);
        return $this->returnData(true, 'Classroom created successfully', 201, $classroom);
    }

    // get a single classroom by id with its grade and academic year
    public function show(string $id)
    {
        $classroom = Classroom::with(['grade', 'academicYear'])->find($id);
        if (!$classroom) {
            return $this->returnData(false, 'Classroom not found', 404);
        }
        return $this->returnData(true, 'Classroom retrieved successfully', 200, $classroom);
    }

    // update a classroom by id
    public function update(string $id, array $data)
    {
        $classroom = Classroom::find($id);
        if (!$classroom) {
            return $this->returnData(false, 'Classroom not found', 404);
        }

        $classroom->update([
            'name' => $data['name'],
            'code' => $data['code'],
            'grade_id' => $data['grade_id'],
            'academic_year_id' => $data['academic_year_id'],
            'capacity' => $data['capacity'] ?? null,
            'status' => $data['status'] ?? 'active',
        ]);

        return $this->returnData(true, 'Classroom updated successfully', 200, $classroom);
    }

    // delete a classroom by id
    public function destroy(string $id)
    {
        $classroom = Classroom::find($id);
        if (!$classroom) {
            return $this->returnData(false, 'Classroom not found', 404);
        }

        $classroom->delete();
        return $this->returnData(true, 'Classroom deleted successfully', 200);
    }

    // get students of a specific classroom
    public function getStudents(string $id)
    {
        $classroom = Classroom::with('students')->find($id);
        if (!$classroom) {
            return $this->returnData(false, 'Classroom not found', 404);
        }
        return $this->returnData(true, 'Students retrieved successfully', 200, $classroom->students);
    }

    // add a student to a specific classroom
    public function addStudent(string $id, array $data)
    {
        $classroom = Classroom::find($id);
        if (!$classroom) {
            return $this->returnData(false, 'Classroom not found', 404);
        }

        $student = Student::find($data['student_id']);
        if (!$student) {
            return $this->returnData(false, 'Student not found', 404);
        }

        $classroom->students()->syncWithoutDetaching($student->id);
        return $this->returnData(true, 'Student added to classroom successfully', 200);
    }

    // remove a student from a specific classroom
    public function removeStudent(string $id, string $studentId)
    {
        $classroom = Classroom::find($id);
        if (!$classroom) {
            return $this->returnData(false, 'Classroom not found', 404);
        }

        $student = Student::find($studentId);
        if (!$student) {
            return $this->returnData(false, 'Student not found', 404);
        }

        $classroom->students()->detach($student->id);
        return $this->returnData(true, 'Student removed from classroom successfully', 200);
    }
}
