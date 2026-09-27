<?php

namespace App\Interface\Api\People;

interface TeacherInterface
{
    // curd operations
    public function index();
    public function store(array $data);
    public function show(int $id);
    public function update(int $id, array $data);
    public function destroy(int $id);

    // relationship operations
    public function getCourses(int $id);
    public function getStudents(int $id);
}
