<?php

namespace App\Policies\Assignments;

use App\Models\User;

class AssignmentPolicy
{
    /**
     * Handle all abilities for super-admin role.
     */
    public function before(User $user, string $ability): ?bool
    {
        if($user->hasRole('super-admin')) {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('assignments.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->can('assignments.view');
    }

    /**
     * Determine whether the user can create the model.
     */
    public function create(User $user): bool
    {
        return $user->can('assignments.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->can('assignments.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->can('assignments.delete');
    }

    /**
     * Determine whether the user can publish the model.
     */
    public function publish(User $user): bool
    {
        return $user->can('assignments.publish');
    }

    /**
     * Determine whether the user can close the model.
     */
    public function close(User $user): bool
    {
        return $user->can('assignments.unpublish');
    }
}
