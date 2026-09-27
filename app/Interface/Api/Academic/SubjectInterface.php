<?php

namespace App\Interface\Api\Academic;

interface SubjectInterface
{
    // curd subjects
    public function index();
    public function store(array $data);
    public function show(string $slug);
    public function update(array $data, string $slug);
    public function destroy(string $slug);

    // Additional Methods
    public function getCourses(string $slug);
    public function getTeachers(string $slug);
}
