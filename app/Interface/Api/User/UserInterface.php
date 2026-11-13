<?php

namespace App\Interface\Api\User;

use App\Models\User;

interface UserInterface
{
    // CRUD Operations
    public function getAllUsers();

    public function createUser(array $data): User;

    public function getUserById(string $id);

    public function getUserByEmail(string $email);

    public function updateUser(User $user, array $data);

    public function deleteUser(User $user);

    public function getMeDetails(User $user);

    // User Preferences Management
    public function getUserPreferences(User $user);

    public function updateUserPreferences(User $user, array $preferences);

    // User Avatar Management
    public function uploadUserAvatar(User $user, $avatar);

    public function deleteUserAvatar(User $user);
}
