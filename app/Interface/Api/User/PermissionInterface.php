<?php

namespace App\Interface\Api\User;

use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

interface PermissionInterface
{
    // CRUD Operations
    public function getAllPermissions();
    public function create(array $data);
    public function findByID(string $id);
    public function findByName(string $name);
    public function update(Permission $permission, array $data);
    public function destroy(Permission $permission);

    public function getAllPermissionsById(array $permissionIds);

    // Role Permissions Management
    public function getPermissionsForRole(Role $role);
    public function assignPermissionToRole(Role $role, array $permissionIds);
    public function removePermissionFromRole(Role $role, string $permissionId);

    // User Permissions Management
    public function getUserPermissions(User $user);
    public function assignPermissionsToUser(User $user, Collection $permissions);
    public function removePermissionFromUser(User $user, Permission $permission);

}
