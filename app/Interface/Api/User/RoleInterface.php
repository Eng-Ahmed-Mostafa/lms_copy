<?php

namespace App\Interface\Api\User;

interface RoleInterface
{
    public function index();
    public function store(array $data);
    public function show(string $id);
    public function update(string $id, array $data);
    public function destroy(string $id);

    public function getPermissions(string $id);
    public function assignPermissions(string $id, array $permissions);
    public function removePermissions(string $id, string $permission);
}
