<?php

namespace App\Services\Assignments;

use App\Interface\Api\Assignments\AssignmentInterface;
use App\Trait\RepositoryTrait;

class AssignmentService
{
    use RepositoryTrait;

    public function __construct(private readonly AssignmentInterface $assignmentInterface) {}

    // get all assignments
    public function getAllAssignments()
    {
        $assignments = $this->assignmentInterface->getAllAssignments();
        return $this->returnData(true, 'Assignments retrieved successfully',200 , $assignments);
    }

    // create assignment
    public function createAssignment(array $data)
    {
        $assignment = $this->assignmentInterface->createAssignment($data);
        if (!$assignment) {
            return $this->returnData(false, 'Failed to create assignment', 400);
        }
        return $this->returnData(true, 'Assignment created successfully',201 , $assignment);
    }

    // get assignment by id
    public function getAssignmentById($id)
    {
        $assignment = $this->assignmentInterface->getAssignmentById($id);
        if (!$assignment) {
            return $this->returnData(false, 'Assignment not found', 404);
        }
        return $this->returnData(true, 'Assignment retrieved successfully',200 , $assignment);
    }

    // update assignment
    public function updateAssignment($id, array $data)
    {
        $assignment = $this->assignmentInterface->updateAssignment($id, $data);
        if (!$assignment) {
            return $this->returnData(false, 'Failed to update assignment', 400);
        }
        return $this->returnData(true, 'Assignment updated successfully',200 , $assignment);
    }

    // delete assignment
    public function deleteAssignment($id)
    {
        $deleted = $this->assignmentInterface->deleteAssignment($id);
        if (!$deleted) {
            return $this->returnData(false, 'Failed to delete assignment', 400);
        }
        return $this->returnData(true, 'Assignment deleted successfully',200 , null);
    }

    // publish assignment
    public function publishAssignment($id)
    {
        $assignment = $this->assignmentInterface->publishAssignment($id);
        if (!$assignment) {
            return $this->returnData(false, 'Failed to publish assignment', 400);
        }
        return $this->returnData(true, 'Assignment published successfully',200 , $assignment);
    }

    // close assignment
    public function closeAssignment($id)
    {
        $assignment = $this->assignmentInterface->closeAssignment($id);
        if (!$assignment) {
            return $this->returnData(false, 'Failed to close assignment', 400);
        }
        return $this->returnData(true, 'Assignment closed successfully',200 , $assignment);
    }
}
