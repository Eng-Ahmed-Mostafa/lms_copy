<?php

namespace App\Interface\Api\Courses;

interface LessonVersionInterface
{
    // curd operations
    public function show(string $id);
    public function update(string $id, array $data);
    public function destroy(string $id);

    // workflow operations
    public function submitForReview(string $id);
    public function approve(string $id);
    public function reject(string $id);
    public function publish(string $id);
}
