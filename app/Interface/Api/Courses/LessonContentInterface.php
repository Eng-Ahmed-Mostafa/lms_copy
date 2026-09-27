<?php

namespace App\Interface\Api\Courses;

interface LessonContentInterface
{
    // curd operations
    public function store(array $data);
    public function show(string $id);
    public function update(string $id, array $data);
    public function destroy(string $id);

    // reorder operation
    public function reorder(string $id, array $data);
}
