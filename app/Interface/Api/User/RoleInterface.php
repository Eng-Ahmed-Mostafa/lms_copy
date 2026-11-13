<?php

namespace App\Interface\Api\User;

use App\Models\User;
use Spatie\Permission\Models\Role;

interface RoleInterface
{
    // CRUD Operations
    public function index();
    public function store(array $data);
    public function show(string $id);
    public function update(Role $role, array $data);
    public function destroy(Role $role);

    // Role Management
    public function getRolesNamesByIds(array $rolesIds);
    public function assignRolesToUser(User $user, array $rolesIds);
    public function removeRolesFromUser(User $user, Role $role);

    // Role Permissions Management
    public function getPermissions(string $id);
    public function assignPermissions(string $id, array $permissions);
    public function removePermissions(string $id, string $permission);

}
