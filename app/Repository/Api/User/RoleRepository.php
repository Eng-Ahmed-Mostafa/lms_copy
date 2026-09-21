<?php

namespace App\Repository\Api\User;

use App\Interface\Api\User\RoleInterface;
use App\Trait\RepositoryTrait;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleInterface
{
    use RepositoryTrait;

    public function index()
    {
        $roles = Role::get();
        return $this->returnData(true, 'Roles retrieved successfully', 200, $roles);
    }

    public function store(array $data)
    {
        $role = Role::create([
            'name' => $data['name'],
            'guard_name' => $data['guard_name'] ?? 'sanctum',
        ]);
        return $this->returnData(true, 'Role created successfully', 201, $role);
    }

    public function show(string $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return $this->returnData(false, 'Role not found', 404);
        }
        return $this->returnData(true, 'Role retrieved successfully', 200, $role);
    }

    public function update(string $id, array $data)
    {
        $role = Role::find($id);
        if (!$role) {
            return $this->returnData(false, 'Role not found', 404);
        }
        $role->update([
            'name' => $data['name'],
            'guard_name' => $data['guard_name'] ?? 'sanctum',
        ]);
        return $this->returnData(true, 'Role updated successfully', 200, $role);
    }

    public function destroy(string $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return $this->returnData(false, 'Role not found', 404);
        }
        $role->delete();
        return $this->returnData(true, 'Role deleted successfully', 200);
    }

    public function getPermissions(string $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return $this->returnData(false, 'Role not found', 404);
        }
        $permissions = $role->permissions;
        return $this->returnData(true, 'Permissions retrieved successfully', 200, $permissions);
    }

    public function assignPermissions(string $id, array $permissions)
    {
        $role = Role::find($id);
        if (!$role) {
            return $this->returnData(false, 'Role not found', 404);
        }
        $role->givePermissionTo($permissions);
        return $this->returnData(true, 'Permissions assigned successfully', 200);
    }

    public function removePermissions(string $id, string $permission)
    {
        $role = Role::find($id);
        if (!$role) {
            return $this->returnData(false, 'Role not found', 404);
        }
        $role->revokePermissionTo($permission);
        return $this->returnData(true, 'Permission removed successfully', 200);
    }
}
