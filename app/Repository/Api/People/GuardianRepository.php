<?php

namespace App\Repository\Api\People;

use App\Interface\Api\People\GuardianInterface;
use App\Models\Guardian;
use App\Models\Student;
use App\Trait\RepositoryTrait;

class GuardianRepository implements GuardianInterface
{
    use RepositoryTrait;

    // get all guardians
    public function index()
    {
        $guardians = Guardian::with('user', 'children')->get();
        return $this->returnData(true, 'Guardians retrieved successfully', 200, $guardians);
    }

    // create a new guardian
    public function store(array $data)
    {
        $guardian = Guardian::create([
            'user_id' => $data['user_id'],
            'occupation' => $data['occupation'],
        ]);
        return $this->returnData(true, 'Guardian created successfully', 201, $guardian);
    }

    // get a specific guardian
    public function show(int $id)
    {
        $guardian = Guardian::with('user', 'children')->find($id);
        if (!$guardian) {
            return $this->returnData(false, 'Guardian not found', 404);
        }
        return $this->returnData(true, 'Guardian retrieved successfully', 200, $guardian);
    }

    // update a specific guardian
    public function update(int $id, array $data)
    {
        $guardian = Guardian::find($id);
        if (!$guardian) {
            return $this->returnData(false, 'Guardian not found', 404);
        }
        $guardian->update([
            'user_id' => $data['user_id'] ?? $guardian->user_id,
            'occupation' => $data['occupation'] ?? $guardian->occupation,
        ]);
        return $this->returnData(true, 'Guardian updated successfully', 200, $guardian);
    }

    // delete a specific guardian
    public function destroy(int $id)
    {
        $guardian = Guardian::find($id);
        if (!$guardian) {
            return $this->returnData(false, 'Guardian not found', 404);
        }
        $guardian->delete();
        return $this->returnData(true, 'Guardian deleted successfully', 200);
    }

    // get children of a specific guardian
    public function getChildren(int $guardianId)
    {
        $guardian = Guardian::with('children')->find($guardianId);
        if (!$guardian) {
            return $this->returnData(false, 'Guardian not found', 404);
        }
        return $this->returnData(true, 'Children retrieved successfully', 200, $guardian->children);
    }

    // add a child to a specific guardian
    public function addChild(int $guardianId, array $data)
    {
        $guardian = Guardian::find($guardianId);
        if (!$guardian) {
            return $this->returnData(false, 'Guardian not found', 404);
        }

        $child = Student::find($data['student_id']);
        if (!$child) {
            return $this->returnData(false, 'Student not found', 404);
        }

        $guardian->children()->syncWithoutDetaching([
            $child->id => [
                'relationship' => $data['relationship'],
                'is_primary' => $data['is_primary'] ?? false,
                'can_view_grades' => $data['can_view_grades'] ?? true,
                'can_view_attendance' => $data['can_view_attendance'] ?? true,
                'can_view_payments' => $data['can_view_payments'] ?? true,
                'can_receive_notifications' => $data['can_receive_notifications'] ?? true,
            ],
        ]);

        return $this->returnData(true, 'Child added successfully', 201, $guardian->children);
    }

    // remove a child from a specific guardian
    public function removeChild(int $guardianId, int $childId)
    {
        $guardian = Guardian::find($guardianId);
        if (!$guardian) {
            return $this->returnData(false, 'Guardian not found', 404);
        }

        $child = $guardian->children()->find($childId);
        if (!$child) {
            return $this->returnData(false, 'Child not found', 404);
        }

        $guardian->children()->detach($childId);

        return $this->returnData(true, 'Child removed successfully', 200);
    }
}
