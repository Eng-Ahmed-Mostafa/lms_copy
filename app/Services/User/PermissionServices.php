<?php

namespace App\Services\User;

use App\Interface\Api\User\PermissionInterface;
use App\Interface\Api\User\RoleInterface;
use App\Interface\Api\User\UserInterface;
use App\Trait\RepositoryTrait;


class PermissionServices
{
    use RepositoryTrait;
    public function __construct(
        private readonly PermissionInterface $permissions,
        private readonly RoleInterface $roleInterface,
        private readonly UserInterface $userInterface,
    ) {}

    //* Manage Permissions
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = $this->permissions->getAllPermissions();
        return $this->returnData(true, 'Permissions retrieved successfully', 200, $permissions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(array $data)
    {
        $permission = $this->permissions->create($data);
        if(!$permission) {
            return $this->returnData(false, 'Failed to create permission', 500);
        }
        return $this->returnData(true, 'Permission created successfully', 201, $permission);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permission = $this->permissions->findByID($id);
        if(!$permission) {
            return $this->returnData(false, 'Permission not found', 404);
        }
        return $this->returnData(true, 'Permission retrieved successfully', 200, $permission);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, array $data)
    {
        $permission = $this->permissions->findByID($id);
        if(!$permission) {
            return $this->returnData(false, 'Permission not found', 404);
        }

        $this->permissions->update($permission, $data);
        return $this->returnData(true, 'Permission updated successfully', 200, $permission);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = $this->permissions->findByID($id);
        if(!$permission) {
            return $this->returnData(false, 'Permission not found', 404);
        }

        $this->permissions->destroy($permission);
        return $this->returnData(true, 'Permission deleted successfully', 200);
    }

    //* Manage Role Permissions
    /**
     * Get permissions by role.
     */
    public function getPermissionsByRoleId(string $roleId)
    {
        $role = $this->roleInterface->show($roleId);
        if(!$role) {
            return $this->returnData(false, 'Role not found', 404);
        }

        $permissions = $this->permissions->getPermissionsForRole($role);
        return $this->returnData(true, 'Permissions retrieved successfully', 200, $permissions);
    }

    /**
     * Assign permissions to a role.
     */
    public function assignPermissionToRole(string $roleId, array $permissionIds)
    {
        $role = $this->roleInterface->show($roleId);
        if(!$role) {
            return $this->returnData(false, 'Role not found', 404);
        }

        $this->permissions->assignPermissionToRole($role, $permissionIds);
        return $this->returnData(true, 'Permission assigned to role successfully', 200);
    }

    /**
     * Remove a permission from a role.
     */
    public function removePermissionFromRole(string $roleId, string $permissionName)
    {
        $role = $this->roleInterface->show($roleId);
        if(!$role) {
            return $this->returnData(false, 'Role not found', 404);
        }

        $permission = $this->permissions->findByName($permissionName);
        if(!$permission) {
            return $this->returnData(false, 'Permission not found', 404);
        }

        if(!$role->hasPermissionTo($permission)) {
            return $this->returnData(false, 'Role does not have this permission', 400);
        }

        $this->permissions->removePermissionFromRole($role, $permissionName);
        return $this->returnData(true, 'Permission removed from role successfully', 200);
    }

    //* Manage User Permissions
    /**
     * Get permissions for a user.
     */
    public function getUserPermissions(string $userId)
    {
        $user = $this->userInterface->getUserById($userId);
        if(!$user) {
            return $this->returnData(false, 'User not found', 404);
        }

        $permissions = $this->permissions->getUserPermissions($user);
        return $this->returnData(true, 'User permissions retrieved successfully', 200, $permissions);
    }

    /**
     * Assign permissions to a user.
     */
    public function assignPermissionsToUser(string $userId, array $permissionIds)
    {
        $user = $this->userInterface->getUserById($userId);
        if(!$user) {
            return $this->returnData(false, 'User not found', 404);
        }

        $permissions = $this->permissions->getAllPermissionsById($permissionIds);
        if(count($permissions) !== count($permissionIds)) {
            return $this->returnData(false, 'One or more permissions not found', 404);
        }

        $this->permissions->assignPermissionsToUser($user, $permissions);
        return $this->returnData(true, 'Permissions assigned to user successfully', 200);
    }

    /**
     * Remove a permission from a user.
     */
    public function removePermissionFromUser(string $userId, string $permissionId)
    {
        $user = $this->userInterface->getUserById($userId);
        if(!$user) {
            return $this->returnData(false, 'User not found', 404);
        }
        $permission = $this->permissions->findByID($permissionId);
        if(!$permission) {
            return $this->returnData(false, 'Permission not found', 404);
        }

        $this->permissions->removePermissionFromUser($user, $permission);
        return $this->returnData(true, 'Permission removed from user successfully', 200);
    }
}
