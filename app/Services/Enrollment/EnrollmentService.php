<?php

namespace App\Services\Enrollment;

use App\Actions\Enrollment\CancelEnrollmentAction;
use App\Actions\Enrollment\CompleteEnrollmentAction;
use App\Actions\Enrollment\CreateEnrollmentAction;
use App\Enum\EnrollmentSource;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;

class EnrollmentService
{
    public function __construct(
        private CreateEnrollmentAction $createEnrollment,
        private CompleteEnrollmentAction $completeEnrollment,
        private CancelEnrollmentAction $cancelEnrollment
    ) {}

    public function enroll(User $user, Course $course, EnrollmentSource $source = EnrollmentSource::SELF, ?int $durationDays = null): Enrollment
    {
        return $this->createEnrollment->execute($user, $course, $source, $durationDays);
    }

    public function complete(Enrollment $enrollment): Enrollment
    {
        return $this->completeEnrollment->execute($enrollment);
    }

    public function cancel(Enrollment $enrollment, ?string $reason = null): Enrollment
    {
        return $this->cancelEnrollment->execute($enrollment, $reason);
    }
}
