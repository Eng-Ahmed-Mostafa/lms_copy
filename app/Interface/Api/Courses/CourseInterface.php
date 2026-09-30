<?php

namespace App\Interface\Api\Courses;

interface CourseInterface
{
    // curd operations
    public function search(array $data);
    public function index();
    public function store(array $data);
    public function show(string $slug);
    public function update(array $data, string $slug);
    public function destroy(string $slug);

    // Chapter operations
    public function getChaptersByCourse(string $slug);
    public function addChapterToCourse(array $data, string $slug);

    // get lessons by course
    public function getLessonsByCourse(string $slug);

    // get students by course
    public function getStudentsByCourse(string $slug);

    // publish, unpublish, archive operations
    public function submitCourseForReview(string $slug);
    public function publishCourse(string $slug);
    public function unpublishCourse(string $slug);
    public function archiveCourse(string $slug);
}
