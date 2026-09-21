<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PermissionRequest;
use App\Http\Requests\User\RoleRequest;
use App\Interface\Api\User\RoleInterface;
use App\Trait\ResponseTrait;

class RoleController extends Controller
{
    use ResponseTrait;

    protected ?RoleInterface $roleService;

    public function __construct(RoleInterface $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->roleService->index();
        return $this->finalResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $result = $this->roleService->store($request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->roleService->show($id);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id)
    {
        $result = $this->roleService->update($id, $request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->roleService->destroy($id);
        return $this->finalResponse($result);
    }

    public function getPermissions(string $id)
    {
        $result = $this->roleService->getPermissions($id);
        return $this->finalResponse($result);
    }

    public function assignPermissions(PermissionRequest $request, string $id)
    {
        $result = $this->roleService->assignPermissions($id, $request->validated());
        return $this->finalResponse($result);
    }

    public function removePermissions(string $id, string $permission)
    {
        $result = $this->roleService->removePermissions($id, $permission);
        return $this->finalResponse($result);
    }
}
