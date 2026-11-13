<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RoleIdsRequest;
use App\Http\Requests\User\RoleRequest;
use App\Models\User;
use App\Services\User\RoleServices;
use App\Trait\ResponseTrait;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly RoleServices $roleService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Role::class);
        $result = $this->roleService->index();
        return $this->finalResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $this->authorize('create', Role::class);
        $result = $this->roleService->store($request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $this->authorize('view', $role);
        $result = $this->roleService->show($role->id);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $this->authorize('update', $role);
        $result = $this->roleService->update($role->id, $request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);
        $result = $this->roleService->destroy($role->id);
        return $this->finalResponse($result);
    }

    /**
     * Get the roles names by their IDs.
     */
    public function getRolesNamesByUserId(User $user)
    {
        $this->authorize('viewAny', $user);
        $result = $this->roleService->getRolesNamesByUserId($user->id);
        return $this->finalResponse($result);
    }

    /**
     * Assign roles to a user.
     */
    public function assignRolesToUser(RoleIdsRequest $request, User $user) {
        $this->authorize('assignRoles', $user);
        $result = $this->roleService->assignRolesToUser($user->id, $request->validated());
        return $this->finalResponse($result);
    }

    /**
     * remove a role from a user.
     */
    public function removeRolesFromUser(User $user, string $roleId) {
        $this->authorize('removeRoles', $user);
        $result = $this->roleService->removeRolesFromUser($user->id, $roleId);
        return $this->finalResponse($result);
    }
}
