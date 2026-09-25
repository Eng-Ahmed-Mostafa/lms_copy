<?php

namespace App\Interface\Api\Courses;

interface CourseCategoryInterface
{
    // curd operations for course category
    public function index();
    public function store(array $data);
    public function show(string $slug);
    public function update(string $slug, array $data);
    public function destroy(string $slug);
}
