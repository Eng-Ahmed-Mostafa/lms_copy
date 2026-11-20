<?php

namespace App\Interface\Api\Assignments;
use App\Models\Assignment;

interface AssignmentInterface
{
    public function getAllAssignments();

    public function createAssignment(array $data): ?Assignment;

    public function getAssignmentById($id): ?Assignment;

    public function updateAssignment($id, array $data): ?Assignment;

    public function deleteAssignment($id): bool;

    public function publishAssignment($id): ?Assignment;

    public function closeAssignment($id): ?Assignment;
}
