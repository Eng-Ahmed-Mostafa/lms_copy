<?php

namespace App\Repository\Api\Enrollment;

use App\Interface\Api\Enrollment\EnrollmentInterface;
use App\Models\Enrollment;

class EnrollmentRepository implements EnrollmentInterface
{
    // Find an enrollment by ID
    public function find(int $id): ?Enrollment
    {
        return Enrollment::with('user', 'course')->find($id);
    }

    // Find an enrollment by user ID and course ID
    public function findByUserAndCourse(int $userId, int $courseId): ?Enrollment
    {
        return Enrollment::where('user_id', $userId)->where('course_id', $courseId)->latest('id')->first();
    }

    // Create a new enrollment
    public function create(array $data): Enrollment
    {
        return Enrollment::create($data);
    }

    // Update an existing enrollment
    public function update(Enrollment $enrollment, array $data): Enrollment
    {
        $enrollment->update($data);
        return $enrollment->refresh();
    }

    // Get all enrollments for a specific user
    public function getUserEnrollments(int $userId)
    {
        return Enrollment::with('course')->where('user_id', $userId)->latest()->get();
    }

    // Get all enrollments for a specific course
    public function getCourseEnrollments(int $courseId)
    {
        return Enrollment::with('user')->where('course_id', $courseId)->latest()->get();
    }
}
