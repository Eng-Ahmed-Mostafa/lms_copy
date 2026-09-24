<?php

namespace App\Repository\Api\People;

use App\Interface\Api\People\TeacherInterface;
use App\Models\Teacher;
use App\Trait\RepositoryTrait;

class TeacherRepository implements TeacherInterface
{
    use RepositoryTrait;

    // get all teachers
    public function index()
    {
        $teachers = Teacher::get();
        return $this->returnData(true, 'Teachers retrieved successfully', 200, $teachers);
    }

    // create a new teacher
    public function store(array $data)
    {
        $teacher = Teacher::create([
            'user_id' => $data['user_id'],
            'employee_number' => $data['employee_number'],
            'bio' => $data['bio'] ?? null,
            'qualification' => $data['qualification'] ?? null,
            'specialization' => $data['specialization'] ?? null,
            'experience_years' => $data['experience_years'] ?? null,
            'hire_date' => $data['hire_date'] ?? null,
            'status' => $data['status'] ?? 'active',
        ]);
        return $this->returnData(true, 'Teacher created successfully', 201, $teacher);
    }

    // get a specific teacher
    public function show(int $id)
    {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return $this->returnData(false, 'Teacher not found', 404);
        }
        return $this->returnData(true, 'Teacher retrieved successfully', 200, $teacher);
    }

    // update a specific teacher
    public function update(int $id, array $data)
    {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return $this->returnData(false, 'Teacher not found', 404);
        }

        $teacher->update([
            'user_id' => $data['user_id'] ?? $teacher->user_id,
            'employee_number' => $data['employee_number'] ?? $teacher->employee_number,
            'bio' => $data['bio'] ?? $teacher->bio,
            'qualification' => $data['qualification'] ?? $teacher->qualification,
            'specialization' => $data['specialization'] ?? $teacher->specialization,
            'experience_years' => $data['experience_years'] ?? $teacher->experience_years,
            'hire_date' => $data['hire_date'] ?? $teacher->hire_date,
            'status' => $data['status'] ?? $teacher->status,
        ]);

        return $this->returnData(true, 'Teacher updated successfully', 200, $teacher);
    }

    // delete a specific teacher
    public function destroy(int $id)
    {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return $this->returnData(false, 'Teacher not found', 404);
        }

        $teacher->delete();
        return $this->returnData(true, 'Teacher deleted successfully', 200);
    }

    // get students associated with a specific teacher
    public function getStudents(int $id)
    {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return $this->returnData(false, 'Teacher not found', 404);
        }
        $students = $teacher->students;
        return $this->returnData(true, 'Students retrieved successfully', 200, $students);
    }
}
