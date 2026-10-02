<?php

namespace App\Interface\Api\Enrollment;

use App\Models\Enrollment;

interface EnrollmentInterface
{
    public function find(int $id): ?Enrollment;
    public function findByUserAndCourse(int $userId, int $courseId): ?Enrollment;
    public function create(array $data): Enrollment;
    public function update(Enrollment $enrollment, array $data): Enrollment;
    public function getUserEnrollments(int $userId);
    public function getCourseEnrollments(int $courseId);
}
