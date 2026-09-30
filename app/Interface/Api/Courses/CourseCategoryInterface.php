<?php

namespace App\Interface\Api\Courses;

interface CourseCategoryInterface
{
    // curd operations for course category
    public function search(array $data);
    public function index();
    public function store(array $data);
    public function show(string $slug);
    public function update(string $slug, array $data);
    public function destroy(string $slug);

    // get courses by category
    public function getCoursesByCategory(string $slug);
}
