<?php

namespace App\Policies;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExamPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'teacher']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Exam $exam): bool
    {
        return $user->hasAnyRole(['admin', 'teacher'])
            || ($exam->status === 'published' && $user->student !== null);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'teacher']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Exam $exam): bool
    {
        return $user->hasRole('admin') || $user->hasRole('teacher');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Exam $exam): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can publish the exam.
     */
    public function publish(User $user, Exam $exam): bool
    {
        return $user->hasAnyRole(['admin', 'teacher']);
    }

    /**
     * Determine whether the user can manage questions for the exam.
     */
    public function manageQuestions(User $user, Exam $exam): bool
    {
        return $user->hasAnyRole(['admin', 'teacher']);
    }

    /**
     * Determine whether the user can view statistics for the exam.
     */
    public function viewStatistics(User $user, Exam $exam): bool
    {
        return $user->hasAnyRole(['admin', 'teacher']);
    }
}
