<?php

namespace App\Actions\Enrollment;

use App\Enum\EnrollmentSource;
use App\Enum\EnrollmentStatus;
use App\Events\Enrollment\EnrollmentCreated;
use App\Interface\Api\Enrollment\EnrollmentInterface;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreateEnrollmentAction
{
    public function __construct(private EnrollmentInterface $repository) {}

    public function execute(User $user, Course $course, EnrollmentSource $source = EnrollmentSource::SELF, ?int $durationDays = null): Enrollment
    {
        return DB::transaction(function () use ($user, $course, $source, $durationDays) {
            if ($course->status !== 'active') {
                throw ValidationException::withMessages(['course' => 'Course is not available for enrollment.']);
            }

            $existing = Enrollment::where('user_id', $user->id)->where('course_id', $course->id)
                ->whereIn('status', [EnrollmentStatus::ACTIVE])
                ->lockForUpdate()
                ->first();

            if ($existing) {
                throw ValidationException::withMessages(['course' => 'You are already enrolled in this course.']);
            }

            $expireAt = $durationDays ? now()->addDays($durationDays) : null;

            $enrollment = $this->repository->create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'source' => $source,
                'status' => EnrollmentStatus::ACTIVE,
                'enrolled_at' => now(),
                'expired_at' => $expireAt,
            ]);

            event(new EnrollmentCreated($enrollment));

            return $enrollment->load(['user', 'course']);
        });

    }
}
