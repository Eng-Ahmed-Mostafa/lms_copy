<?php

namespace App\Listeners\Enrollment;

use App\Events\Enrollment\EnrollmentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEnrollmentConfirmation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EnrollmentCreated $event): void
    {
        $enrollment = $event->enrollment;

        $user = $enrollment->user;
    }
}
