<?php

namespace App\Actions\Enrollment;

use App\Enum\EnrollmentStatus;
use App\Events\Enrollment\EnrollmentCompleted;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CompleteEnrollmentAction
{
    public function execute(Enrollment $enrollment): Enrollment
    {
        return DB::transaction(function () use ($enrollment) {
            $enrollment->lockForUpdate();

            if (!$enrollment->isActive()) {
                throw ValidationException::withMessages(['enrollment' => 'Enrollment is not active and cannot be completed.']);
            }

            $enrollment->update([
                'status' => EnrollmentStatus::COMPLETED,
                'completed_at' => now(),
            ]);

            event(new EnrollmentCompleted($enrollment));

            return $enrollment->refresh();
        });
    }
}
