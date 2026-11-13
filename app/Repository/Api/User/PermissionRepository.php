<?php

namespace App\Repository\Api\User;

use App\Interface\Api\User\PermissionInterface;
use App\Models\User;
use App\Trait\RepositoryTrait;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRepository implements PermissionInterface
{
    use RepositoryTrait;

    // get all permissions
    public function getAllPermissions()
    {
        return Permission::get();
    }

    // create a new permission
    public function create(array $data)
    {
        return Permission::create([
            'name' => $data['name'],
            'guard_name' => $data['guard_name'] ?? 'sanctum',
        ]);
    }

    // get a specific permission by ID
    public function findByID(string $id)
    {
        return Permission::find($id);
    }

    // get a specific permission by name
    public function findByName(string $name)
    {
        return Permission::where('name', $name)->first();
    }

    // update a specific permission by ID
    public function update(Permission $permission, array $data)
    {
        $permission->update([
            'name' => $data['name'],
            'guard_name' => $data['guard_name'] ?? 'sanctum',
        ]);
    }

    // delete a specific permission by ID
    public function destroy(Permission $permission)
    {
        $permission->delete();
    }

    public function getAllPermissionsById(array $permissionIds)
    {
        return Permission::whereIn('id', $permissionIds)->get();
    }

    // Role Permissions Management
    public function getPermissionsForRole(Role $role)
    {
        return $role->permissions;
    }

    public function assignPermissionToRole(Role $role, array $permissionIds)
    {
        $role->givePermissionTo($permissionIds);
    }

    public function removePermissionFromRole(Role $role, string $permissionId)
    {
        $role->revokePermissionTo($permissionId);
        return $role;
    }

    public function removePermissionFromRoleByName(Role $role, string $permissionName)
    {
        $role->revokePermissionTo($permissionName);
        return $role;
    }

    // User Permissions Management
    public function getUserPermissions(User $user)
    {
        return $user->getAllPermissions()->pluck('name')->toArray();
    }

    public function assignPermissionsToUser(User $user, Collection $permissions)
    {
        $user->syncPermissions($permissions);
    }

    public function removePermissionFromUser(User $user, Permission $permission)
    {
        $user->revokePermissionTo($permission);
    }
}

