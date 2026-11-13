<?php

namespace App\Policies\User;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
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
        return $user->can('users.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $target): bool
    {
        return $user->can('users.view', $target) || $user->is($target);
    }

    /**
     * Determine whether the user can create the model.
     */
    public function create(User $user): bool
    {
        return $user->can('users.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $target): bool
    {
        return $user->can('users.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $target): bool
    {
        return $user->can('users.delete') && !$user->is($target);
    }

    /**
     * Determine whether the user can view the preferences of the model.
     */
    public function showPreferences(User $user, User $target): bool
    {
        return $user->is($target);
    }

    /**
     * Determine whether the user can update the preferences of the model.
     */
    public function updatePreferences(User $user, User $target): bool
    {
        return $user->is($target);
    }

    /**
     * Determine whether the user can view the roles of the model.
     */
    public function viewRoles(User $user, User $target): bool
    {
        return $user->can('roles.view') || $user->is($target);
    }

    /**
     * Determine whether the user can assign roles to the model.
     */
    public function assignRoles(User $user, User $target): bool
    {
        return $user->can('roles.assign') && !$user->is($target);
    }

    /**
     * Determine whether the user can remove roles from the model.
     */
    public function removeRoles(User $user, User $target): bool
    {
        return $user->can('roles.delete') && !$user->is($target);
    }

    /**
     * Determine whether the user can view the permissions of the model.
     */
    public function viewPermissions(User $user, User $target): bool
    {
        return $user->can('permissions.view') || $user->is($target);
    }

    /**
     * Determine whether the user can assign permissions to the model.
     */
    public function assignPermissions(User $user, User $target): bool
    {
        return $user->can('permissions.assign') && !$user->is($target);
    }
}
