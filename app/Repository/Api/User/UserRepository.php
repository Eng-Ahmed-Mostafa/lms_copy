<?php

namespace App\Repository\Api\User;

use App\Interface\Api\User\UserInterface;
use App\Models\User;
use App\Trait\RepositoryTrait;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

class UserRepository implements UserInterface
{
    use RepositoryTrait;

    //  get all users
    public function index()
    {
        $users = User::get();
        return $this->returnData(true, 'Users retrieved successfully', 200, $users);
    }

    //  create a new user
    public function store(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'avatar' => $data['avatar'] ?? null,
            'gender' => $data['gender'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'status' => $data['status'] ?? 'active',
        ]);

        return $this->returnData(true, 'User created successfully', 201, $user);
    }

    //  get a specific user by ID
    public function show(string $id)
    {
        $user = User::find($id);
        if(!$user) {
            return $this->returnData(false, 'User not found', 404);
        }
        return $this->returnData(true, 'User retrieved successfully', 200, $user);
    }

    //  update a specific user by ID
    public function update(string $id, array $data)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }

        $user->update($data);

        return $this->returnData(true, 'User updated successfully', 200, $user);
    }

    //  delete a specific user by ID
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }

        $user->delete();

        return $this->returnData(true, 'User deleted successfully', 200);
    }

    //  get roles of a specific user by ID
    public function getUserRoles(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }

        $roles = $user->getRoleNames();

        return $this->returnData(true, 'User roles retrieved successfully', 200, $roles);
    }

    //  assign roles to a specific user by ID
    public function assignRoles(string $id, array $roleIds)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }

        $roles =Role::whereIn('id', $roleIds)->pluck('name')->toArray();
        $user->assignRole($roles);

        return $this->returnData(true, 'Roles assigned to user successfully', 200);
    }

    //  remove a role from a specific user by ID
    public function removeRole(string $id, string $roleId)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }

        $role = Role::find($roleId);
        if (!$role) {
            return $this->returnData(false, 'Role not found', 404);
        }

        $user->removeRole($role);

        return $this->returnData(true, 'Role removed from user successfully', 200);
    }

    //  get permissions of a specific user by ID
    public function getUserPermissions(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }

        $permissions = $user->getAllPermissions()->pluck('name')->toArray();

        return $this->returnData(true, 'User permissions retrieved successfully', 200, $permissions);
    }

    //  get preferences of a specific user by ID
    public function getUserPreferences(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }

        $preferences = $user->preferences()->first(); // Assuming preferences is a JSON column in the users table

        return $this->returnData(true, 'User preferences retrieved successfully', 200, $preferences);
    }

    //  update preferences of a specific user by ID
    public function updateUserPreferences(string $id, array $preferences)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }

        $data = [
            'language' => $preferences['language'] ?? $user->preferences->language,
            'theme' => $preferences['theme'] ?? $user->preferences->theme,
            'timezone' => $preferences['timezone'] ?? $user->preferences->timezone,
            'email_notifications' => $preferences['email_notifications'] ?? $user->preferences->email_notifications,
            'sms_notifications' => $preferences['sms_notifications'] ?? $user->preferences->sms_notifications,
            'push_notifications' => $preferences['push_notifications'] ?? $user->preferences->push_notifications,
        ];

        $user->preferences()->update($data);

        return $this->returnData(true, 'User preferences updated successfully', 200, $data);
    }

    //  upload avatar for a specific user by ID
    public function uploadAvatar(string $id, $avatar)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }

        // Delete old avatar
        if ($user->avatar) {
            $this->handleAvatarDeletion($user->avatar);
        }

        // Upload new avatar
        $avatarPath = $this->handleAvatarUpload($avatar);

        $user->avatar = $avatarPath;
        $user->save();

        return $this->returnData(true, 'User avatar uploaded successfully', 200, ['avatar' => $avatarPath]);
    }

    //  delete avatar for a specific user by ID
    public function deleteAvatar(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->returnData(false, 'User not found', 404);
        }

        if ($user->avatar) {
            // Assuming you have a method to handle the avatar deletion
            $this->handleAvatarDeletion($user->avatar);

            $user->avatar = null;
            $user->save();
        }

        return $this->returnData(true, 'User avatar deleted successfully', 200);
    }

    //  Handle avatar upload
    private function handleAvatarUpload($avatar)
    {
        $path = $avatar->store('avatars', 'public');
        return $path;
    }

    //  Handle avatar deletion
    private function handleAvatarDeletion($avatarPath)
    {
        if ($avatarPath) {
            Storage::disk('public')->delete($avatarPath);
        }
    }
}
