<?php

namespace App\Interface\Api\Courses;

interface ChapterInterface
{
    // curd operations
    public function search(array $data);
    public function index();
    public function store(array $data);
    public function show(string $id);
    public function update(array $data, string $id);
    public function destroy(string $id);

    //? Chapter Lessons Management
    public function getLessons(string $id);
    public function addLesson(array $data, string $id);

    //? Reorder Chapters
    public function reorder(array $data, string $id);
}
