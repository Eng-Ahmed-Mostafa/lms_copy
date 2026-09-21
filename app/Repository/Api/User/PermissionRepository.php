<?php

namespace App\Repository\Api\User;

use App\Interface\Api\User\PermissionInterface;
use App\Trait\RepositoryTrait;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionInterface
{
    use RepositoryTrait;

    // get all permissions
    public function index()
    {
        $permissions = Permission::get();
        return $this->returnData(true, 'Permissions retrieved successfully', 200, $permissions);
    }

    // create a new permission
    public function store(array $data)
    {
        $permission = Permission::create([
            'name' => $data['name'],
            'guard_name' => $data['guard_name'] ?? 'sanctum',
        ]);
        return $this->returnData(true, 'Permission created successfully', 201, $permission);
    }

    // get a specific permission by ID
    public function show(string $id)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            return $this->returnData(false, 'Permission not found', 404);
        }
        return $this->returnData(true, 'Permission retrieved successfully', 200, $permission);
    }

    // update a specific permission by ID
    public function update(string $id, array $data)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            return $this->returnData(false, 'Permission not found', 404);
        }
        $permission->update([
            'name' => $data['name'],
            'guard_name' => $data['guard_name'] ?? 'sanctum',
        ]);
        return $this->returnData(true, 'Permission updated successfully', 200, $permission);
    }

    // delete a specific permission by ID
    public function destroy(string $id)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            return $this->returnData(false, 'Permission not found', 404);
        }
        $permission->delete();
        return $this->returnData(true, 'Permission deleted successfully', 200);
    }
}
