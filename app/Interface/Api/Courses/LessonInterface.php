<?php

namespace App\Interface\Api\Courses;

interface LessonInterface
{
    // Curd Operations
    public function search(array $data);
    public function index();
    public function store(array $data);
    public function show(string $id);
    public function update(array $data, string $id);
    public function destroy(string $id);

    // Lesson Content Management
    public function getContents(string $id);

    // Lesson Version Management
    public function getVersions(string $id);
    public function createVersion(array $data, string $id);
    public function getVersion(string $id, string $versionId);

    // Additional Lesson Actions
    public function submitForApproval(string $id);
    public function publish(string $id);
    public function unpublish(string $id);

    // Reorder Lessons
    public function reorder(array $data, string $id);
}
