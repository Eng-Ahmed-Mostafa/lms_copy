<?php

namespace App\Interface\Api\User;

interface UserInterface
{
    public function index();
    public function store(array $data);
    public function show(string $id);
    public function update(string $id, array $data);
    public function destroy(string $id);

    public function getUserRoles(string $id);
    public function assignRoles(string $id, array $roles);
    public function removeRole(string $id, string $roleId);

    public function getUserPermissions(string $id);

    public function getUserPreferences(string $id);
    public function updateUserPreferences(string $id, array $preferences);

    public function uploadAvatar(string $id, $avatar);
    public function deleteAvatar(string $id);
}
