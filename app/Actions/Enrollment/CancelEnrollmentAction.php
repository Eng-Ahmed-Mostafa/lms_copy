<?php

namespace App\Actions\Enrollment;

use App\Enum\EnrollmentStatus;
use App\Events\Enrollment\EnrollmentCancelled;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CancelEnrollmentAction
{
    public function execute(Enrollment $enrollment, ?string $reason = null): Enrollment
    {
        return DB::transaction(function () use ($enrollment, $reason) {
            $enrollment->lockForUpdate();

            if (!$enrollment->isActive()) {
                throw ValidationException::withMessages(['enrollment' => 'Enrollment is not active and cannot be cancelled.']);
            }

            $enrollment->update([
                'status' => EnrollmentStatus::CANCELLED,
                'cancelled_at' => now(),
                'cancellation_reason' => $reason,
            ]);

            event(new EnrollmentCancelled($enrollment));

            return $enrollment->refresh();
        });
    }
}
