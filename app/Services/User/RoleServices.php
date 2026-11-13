<?php

namespace App\Services\User;

use App\Interface\Api\User\RoleInterface;
use App\Interface\Api\User\UserInterface;
use App\Trait\RepositoryTrait;

class RoleServices
{
    use RepositoryTrait;
    public function __construct(
        private readonly RoleInterface $role,
        private readonly UserInterface $user
    ) {}

    public function index()
    {
        $roles = $this->role->index();
        return $this->returnData(true, 'Roles retrieved successfully', 200, $roles);
    }

    public function store(array $data)
    {
        $role = $this->role->store($data);
        if(!$role) {
            return $this->returnData(false, 'Failed to create role', 500);
        }
        return $this->returnData(true, 'Role created successfully', 201, $role);
    }

    public function show(string $id)
    {
        $role = $this->role->show($id);
        if(!$role) {
            return $this->returnData(false, 'Role not found', 404);
        }
        return $this->returnData(true, 'Role retrieved successfully', 200, $role);
    }

    public function update(string $id, array $data)
    {
        $roleModel = $this->role->show($id);
        if(!$roleModel) {
            return $this->returnData(false, 'Role not found', 404);
        }

        $role = $this->role->update($roleModel, $data);
        if(!$role) {
            return $this->returnData(false, 'Failed to update role', 500);
        }
        return $this->returnData(true, 'Role updated successfully', 200, $role);
    }

    public function destroy(string $id)
    {
        $roleModel = $this->role->show($id);
        if(!$roleModel) {
            return $this->returnData(false, 'Role not found', 404);
        }

        $this->role->destroy($roleModel);
        return $this->returnData(true, 'Role deleted successfully', 200);
    }




    public function getRolesNamesByUserId(string $userId)
    {
        $user = $this->user->getUserById($userId);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }

        $rolesNames = $user->roles()->pluck('name');
        return $this->returnData(true, 'Roles names retrieved successfully', 200, $rolesNames);
    }


    public function assignRolesToUser(string $userId, array $rolesIds)
    {
        $user = $this->user->getUserById($userId);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }
        $assignedRoles = $this->role->assignRolesToUser($user, $rolesIds);
        return $this->returnData(true, 'Roles assigned to user successfully', 200, $assignedRoles);
    }

    public function removeRolesFromUser(string $userId, string $roleId)
    {
        $user = $this->user->getUserById($userId);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }

        $role = $this->role->show($roleId);
        if (!$role) {
            return $this->returnData(false, 'Role not found', 404);
        }

        if (!$user->hasRole($role)) {
            return $this->returnData(false, 'User does not have this role', 400);
        }

        $user->removeRole($role);
        return $this->returnData(true, 'Role removed from user successfully', 200);
    }
}
