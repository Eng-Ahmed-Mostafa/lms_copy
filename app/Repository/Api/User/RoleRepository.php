<?php

namespace App\Repository\Api\User;
use App\Interface\Api\User\RoleInterface;
use App\Models\User;
use App\Trait\RepositoryTrait;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleInterface
{
    use RepositoryTrait;

    // get all roles
    public function index()
    {
        return Role::get();
    }

    // create a new role
    public function store(array $data)
    {
        return Role::create([
            'name' => $data['name'],
            'guard_name' => $data['guard_name'] ?? 'sanctum',
        ]);
    }

    // get a specific role by ID
    public function show(string $id)
    {
        return Role::find($id);
    }

    // update a specific role by ID
    public function update(Role $role, array $data)
    {
        return $role->update([
            'name' => $data['name'],
            'guard_name' => $data['guard_name'] ?? 'sanctum',
        ]);
    }

    // delete a specific role by ID
    public function destroy(Role $role)
    {
        $role->delete();
    }

    // get roles names by IDs
    public function getRolesNamesByIds(array $rolesIds) {
        return Role::whereIn('id', $rolesIds)->pluck('name')->toArray();

    }

    // assign roles to a user
    public function assignRolesToUser(User $user, array $rolesIds) {
        $user->syncRoles($rolesIds);
        return $user->getRoleNames();
    }

    // remove a role from a user
    public function removeRolesFromUser(User $user, Role $role) {
        $user->removeRole($role);
        return $user->getRoleNames();
    }

    // Role Permissions Management
    public function getPermissions(string $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return $this->returnData(false, 'Role not found', 404);
        }
        $permissions = $role->permissions;
        return $this->returnData(true, 'Permissions retrieved successfully', 200, $permissions);
    }

    // Assign permissions to a role
    public function assignPermissions(string $id, array $permissions)
    {
        $role = Role::find($id);
        if (!$role) {
            return $this->returnData(false, 'Role not found', 404);
        }
        $role->givePermissionTo($permissions);
        return $this->returnData(true, 'Permissions assigned successfully', 200);
    }

    // Remove a permission from a role
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
