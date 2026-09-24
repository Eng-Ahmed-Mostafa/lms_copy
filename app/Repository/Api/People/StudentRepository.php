<?php

namespace App\Repository\Api\People;

use App\Interface\Api\People\StudentInterface;
use App\Models\Student;
use App\Trait\RepositoryTrait;

class StudentRepository implements StudentInterface
{
    use RepositoryTrait;

    // get all students
    public function index()
    {
        $students = Student::get();
        return $this->returnData(true, 'Students retrieved successfully', 200, $students);
    }

    // create a new student
    public function store(array $data)
    {
        $student = Student::create([
            'user_id' => $data['user_id'],
            'student_number' => $data['student_number'],
            'grade_id' => $data['grade_id'],
            'classroom_id' => $data['classroom_id'],
            'academic_year_id' => $data['academic_year_id'],
            'enrollment_date' => $data['enrollment_date'] ?? null,
            'status' => $data['status'] ?? 'active',
        ]);
        return $this->returnData(true, 'Student created successfully', 201, $student);
    }

    // get a specific student
    public function show(int $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return $this->returnData(false, 'Student not found', 404);
        }
        return $this->returnData(true, 'Student retrieved successfully', 200, $student);
    }

    // update a specific student
    public function update(int $id, array $data)
    {
        $student = Student::find($id);
        if (!$student) {
            return $this->returnData(false, 'Student not found', 404);
        }

        $student->update([
            'user_id' => $data['user_id'] ?? $student->user_id,
            'student_number' => $data['student_number'] ?? $student->student_number,
            'grade_id' => $data['grade_id'] ?? $student->grade_id,
            'classroom_id' => $data['classroom_id'] ?? $student->classroom_id,
            'academic_year_id' => $data['academic_year_id'] ?? $student->academic_year_id,
            'enrollment_date' => $data['enrollment_date'] ?? $student->enrollment_date,
            'status' => $data['status'] ?? $student->status,
        ]);

        return $this->returnData(true, 'Student updated successfully', 200, $student);
    }

    // delete a specific student
    public function destroy(int $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return $this->returnData(false, 'Student not found', 404);
        }

        $student->delete();
        return $this->returnData(true, 'Student deleted successfully', 200);
    }

    // get teachers associated with a specific student
    public function getTeachers(int $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return $this->returnData(false, 'Student not found', 404);
        }
        $teachers = $student->teachers;
        return $this->returnData(true, 'Teachers retrieved successfully', 200, $teachers);
    }
}
