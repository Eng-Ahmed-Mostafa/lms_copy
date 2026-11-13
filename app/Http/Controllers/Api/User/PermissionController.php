<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PermissionIdsRequest;
use App\Http\Requests\User\PermissionRequest;
use App\Services\User\PermissionServices;
use App\Trait\ResponseTrait;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private readonly PermissionServices $permissionService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->permissionService->index();
        return $this->finalResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
        $result = $this->permissionService->store($request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->permissionService->show($id);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, string $id)
    {
        $result = $this->permissionService->update($id, $request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->permissionService->destroy($id);
        return $this->finalResponse($result);
    }

    /**
     * Get permissions by role.
     */
    public function getPermissionsByRole(Role $role)
    {
        $this->authorize('viewPermissions', $role);
        $result = $this->permissionService->getPermissionsByRoleId($role->id);
        return $this->finalResponse($result);
    }

    /**
     * Assign permissions to a role.
     */
    public function assignPermissionsToRole(Role $role, PermissionIdsRequest $request)
    {
        $this->authorize('assignPermissions', $role);
        $result = $this->permissionService->assignPermissionToRole($role->id, $request->validated('permission_ids'));
        return $this->finalResponse($result);
    }

    /**
     * Remove a permission from a role.
     */
    public function removePermissionFromRole(string $roleId, string $permissionName)
    {
        $this->authorize('removePermissions', Role::findOrFail($roleId));
        $result = $this->permissionService->removePermissionFromRole($roleId, $permissionName);
        return $this->finalResponse($result);
    }

    /**
     * get permissions for user by user id
     */
    public function getUserPermissions(string $userId)
    {
        $result = $this->permissionService->getUserPermissions($userId);
        return $this->finalResponse($result);
    }

    /**
     * assign permissions to user by user id
     */
    public function assignPermissionsToUser(string $userId, PermissionIdsRequest $request)
    {
        $result = $this->permissionService->assignPermissionsToUser($userId, $request->validated('permission_ids'));
        return $this->finalResponse($result);
    }

    /**
     * remove permission from user by user id
     */
    public function removePermissionFromUser(string $userId, string $permissionId)
    {
        $result = $this->permissionService->removePermissionFromUser($userId, $permissionId);
        return $this->finalResponse($result);
    }
}
