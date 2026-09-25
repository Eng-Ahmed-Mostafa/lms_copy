<?php

namespace App\Interface\Api\Courses;

interface CourseInterface
{
    // curd operations
    public function index();
    public function store(array $data);
    public function show(string $slug);
    public function update(array $data, string $slug);
    public function destroy(string $slug);

    // get students by course
    public function getStudentsByCourse(string $slug);

    // publish, unpublish, archive operations
    public function publishCourse(string $slug);
    public function unpublishCourse(string $slug);
    public function archiveCourse(string $slug);
}
