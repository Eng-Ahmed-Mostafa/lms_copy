<?php

namespace App\Repository\Api\Assignments;

use App\Interface\Api\Assignments\AssignmentInterface;
use App\Models\Assignment;

class AssignmentRepository implements AssignmentInterface
{
    public function getAllAssignments()
    {
        return Assignment::all();
    }

    public function createAssignment(array $data): ?Assignment
    {
        return Assignment::create($data);
    }

    public function getAssignmentById($id): ?Assignment
    {
        return Assignment::find($id);
    }

    public function updateAssignment($id, array $data): ?Assignment
    {
        $assignment = Assignment::find($id);
        $assignment->update($data);
        return $assignment;
    }

    public function deleteAssignment($id): bool
    {
        return Assignment::destroy($id);
    }

    public function publishAssignment($id): ?Assignment
    {
        $assignment = Assignment::find($id);
        $assignment->update(['status' => 'published']);
        return $assignment;
    }

    public function closeAssignment($id): ?Assignment
    {
        $assignment = Assignment::find($id);
        $assignment->close();
        return $assignment;
    }
}
