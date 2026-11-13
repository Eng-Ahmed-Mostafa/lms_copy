<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Interface\Api\User\UserInterface;
use App\Trait\RepositoryTrait;

class UserServices
{
    use RepositoryTrait;
    public function __construct(
        private readonly UserInterface $user,
    ) {}

    /**
     * Get all users.
     */
    public function getAllUsers()
    {
        $users = $this->user->getAllUsers();
        return $this->returnData(true, 'Users retrieved successfully', 200, $users);
    }

    /**
     * Create a new user.
     */
    public function createUser(array $data): array
    {
        $user = $this->user->createUser($data);
        if (!$user) {
            return $this->returnData(false, 'Failed to create user', 500);
        }
        return $this->returnData(true, 'User created successfully', 201, $user);
    }

    /**
     * Get a user by ID.
     */
    public function getUserById(string $id)
    {
        $user = $this->user->getUserById($id);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }
        return $this->returnData(true, 'User retrieved successfully', 200, $user);
    }

    /**
     * Get a user by email.
     */
    public function getUserByEmail(string $email)
    {
        $user = $this->user->getUserByEmail($email);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }
        return $this->returnData(true, 'User retrieved successfully', 200, $user);
    }

    /**
     * Update a user.
     */
    public function updateUser(string $userId, array $data)
    {
        $user = $this->user->getUserById($userId);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }
        $updatedUser = $this->user->updateUser($user, $data);
        if (!$updatedUser) {
            return $this->returnData(false, 'Failed to update user', 500);
        }
        return $this->returnData(true, 'User updated successfully', 200, $updatedUser);
    }

    /**
     * Delete a user.
     */
    public function deleteUser(string $userId)
    {
        $user = $this->user->getUserById($userId);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }
        $deletedUser = $this->user->deleteUser($user);
        if (!$deletedUser) {
            return $this->returnData(false, 'Failed to delete user', 500);
        }
        return $this->returnData(true, 'User deleted successfully', 200);
    }

    /**
     * Get the authenticated user's details.
     */
    public function getMeDetails(Request $request)
    {
        $me = $this->user->getMeDetails($request->user());
        if (!$me) {
            return $this->returnData(false, 'Failed to retrieve user details', 500);
        }
        return $this->returnData(true, 'User details retrieved successfully', 200, $me);
    }

    /**
     * Get the authenticated user's preferences.
     */
    public function getUserPreferences(string $userId)
    {
        $user = $this->user->getUserById($userId);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }
        $preferences = $this->user->getUserPreferences($user);
        if (!$preferences) {
            return $this->returnData(false, 'Failed to retrieve user preferences', 500);
        }
        return $this->returnData(true, 'User preferences retrieved successfully', 200, $preferences);
    }

    /**
     * Update the authenticated user's preferences.
     */
    public function updateUserPreferences(string $userId, array $preferences)
    {
        $user = $this->user->getUserById($userId);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }
        $this->user->updateUserPreferences($user, $preferences);
        return $this->returnData(true, 'User preferences updated successfully', 200);
    }

    /**
     * Upload an avatar for the authenticated user.
     */
    public function uploadUserAvatar(string $userId, $avatar)
    {
        $user = $this->user->getUserById($userId);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }

        $this->user->uploadUserAvatar($user, $avatar);
        return $this->returnData(true, 'User avatar uploaded successfully', 200);
    }

    /**
     * Delete the authenticated user's avatar.
     */
    public function deleteUserAvatar(string $userId)
    {
        $user = $this->user->getUserById($userId);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }

        $this->user->deleteUserAvatar($user);
        return $this->returnData(true, 'User avatar deleted successfully', 200);
    }
}
