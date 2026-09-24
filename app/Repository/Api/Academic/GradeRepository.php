<?php

namespace App\Repository\Api\Academic;

use App\Interface\Api\Academic\GradeInterface;
use App\Models\Grade;
use App\Trait\RepositoryTrait;
use Illuminate\Support\Facades\DB;

class GradeRepository implements GradeInterface
{
    use RepositoryTrait;

    // get all grades
    public function index()
    {
        $grades = Grade::get();
        return $this->returnData(true, 'Grades retrieved successfully', 200, $grades);
    }

    // create a new grade
    public function store(array $data)
    {
        $grade = Grade::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'order' => $data['order'] ?? null,
            'status' => $data['status'] ?? null,
        ]);

        return $this->returnData(true, 'Grade created successfully', 201, $grade);
    }

    // get a specific grade by slug
    public function show(string $slug)
    {
        $grade = Grade::where('slug', $slug)->first();
        if (!$grade) {
            return $this->returnData(false, 'Grade not found', 404);
        }
        return $this->returnData(true, 'Grade retrieved successfully', 200, $grade);
    }

    // update a specific grade by slug
    public function update(array $data, string $slug)
    {
        $grade = Grade::where('slug', $slug)->first();
        if (!$grade) {
            return $this->returnData(false, 'Grade not found', 404);
        }
        $grade->update([
            'name' => $data['name'] ?? $grade->name,
            'description' => $data['description'] ?? $grade->description,
            'order' => $data['order'] ?? $grade->order,
            'status' => $data['status'] ?? $grade->status,
        ]);
        return $this->returnData(true, 'Grade updated successfully', 200, $grade);
    }

    // delete a specific grade by slug
    public function destroy(string $slug)
    {
        $grade = Grade::where('slug', $slug)->first();
        if (!$grade) {
            return $this->returnData(false, 'Grade not found', 404);
        }
        $grade->delete();
        return $this->returnData(true, 'Grade deleted successfully', 200);
    }

    // get classrooms for a specific grade by slug
    public function getClassrooms(string $slug)
    {
        $grade = Grade::where('slug', $slug)->first();
        if (!$grade) {
            return $this->returnData(false, 'Grade not found', 404);
        }
        $classrooms = $grade->classrooms;
        return $this->returnData(true, 'Classrooms retrieved successfully', 200, $classrooms);
    }

    // get students for a specific grade by slug
    public function getStudents(string $slug)
    {
        $grade = Grade::where('slug', $slug)->first();
        if (!$grade) {
            return $this->returnData(false, 'Grade not found', 404);
        }
        $students = $grade->students;
        return $this->returnData(true, 'Students retrieved successfully', 200, $students);
    }

    // get subjects for a specific grade by slug
    public function getSubjects(string $slug)
    {
        $grade = Grade::where('slug', $slug)->first();
        if (!$grade) {
            return $this->returnData(false, 'Grade not found', 404);
        }
        $subjects = $grade->subjects;
        return $this->returnData(true, 'Subjects retrieved successfully', 200, $subjects);
    }
}
