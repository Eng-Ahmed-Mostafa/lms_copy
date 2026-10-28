<?php

namespace App\Policies\Assessments;

use App\Models\ExamAttempt;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExamAttemptPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ExamAttempt $examAttempt): bool
    {
        return $this->ownsAttempt($user, $examAttempt);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ExamAttempt $examAttempt): bool
    {
        return $this->ownsAttempt($user, $examAttempt) && $examAttempt->status === 'in_progress';
    }

    /**
     * Determine whether the user can submit the model.
     */
    public function submit(User $user, ExamAttempt $examAttempt): bool
    {
        return $this->ownsAttempt($user, $examAttempt) && $examAttempt->status === 'in_progress';
    }

    /**
     * Determine whether the user can delete the model.
     */
    private function ownsAttempt(User $user, ExamAttempt $examAttempt): bool
    {
        $examAttempt->loadMissing('student');
        return $examAttempt->student !== null
        && (int) $examAttempt->student->user_id === (int) $user->id;
    }
}
