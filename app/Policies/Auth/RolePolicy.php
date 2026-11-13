<?php

namespace App\Policies\Auth;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    /**
     * Handle all abilities for super-admin role.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('roles.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): bool
    {
        return $user->can('roles.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('roles.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role): bool
    {
        return $user->can('roles.update') && $role->name !== 'super-admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): bool
    {
        return $user->can('roles.delete') && $role->name !== 'super-admin';
    }

    /**
     * Determine whether the user can view permissions of the role.
     */
    public function viewPermissions(User $user, Role $role): bool
    {
        return $user->can('permissions.view');
    }

    /**
     * Determine whether the user can assign permissions to the role.
     */
    public function assignPermissions(User $user, Role $role): bool
    {
        return $user->can('permissions.assign') && $role->name !== 'super-admin';
    }

    /**
     * Determine whether the user can remove permissions from the role.
     */
    public function removePermissions(User $user, Role $role): bool
    {
        return $user->can('permissions.remove') && $role->name !== 'super-admin';
    }
}
