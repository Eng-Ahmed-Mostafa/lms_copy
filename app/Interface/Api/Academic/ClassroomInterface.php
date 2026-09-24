<?php

namespace App\Interface\Api\Academic;

interface ClassroomInterface
{
    // crud methods for classroom
    public function index();
    public function store(array $data);
    public function show(string $id);
    public function update(string $id, array $data);
    public function destroy(string $id);

    // additional methods for classroom
    public function getStudents(string $id);
    public function addStudent(string $id, array $data);
    public function removeStudent(string $id, string $studentId);
}
