<?php

namespace App\Policies\Enrollment;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;

class EnrollmentPolicy
{
    public function enroll(User $user, Course $course): bool
    {
        return $user->status === 'active' && $course->status === 'active';
    }

    public function view(User $user, Enrollment $enrollment): bool
    {
        if($user->id === $enrollment->user_id) {
            return true;
        }

        if($enrollment->course->teacher_id === $user->id) {
            return true;
        }

        return $user->hasRole('admin');
    }

    public function cancel(User $user, Enrollment $enrollment): bool
    {
        if($user->id === $enrollment->user_id) {
            return $enrollment->isActive();
        }

        return $user->hasRole('admin');
    }

    public function complete(User $user, Enrollment $enrollment): bool
    {
        return $user->hasRole('admin') || $enrollment->course->teacher_id === $user->id;
    }
}
