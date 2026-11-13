<?php

namespace App\Repository\Api\User;

use App\Interface\Api\User\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Override;

class UserRepository implements UserInterface
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function createUser(array $data): User
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'gender' => $data['gender'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'status' => $data['status'] ?? 'active',
        ]);

        if(!empty($data['avatar'])) {
            $user->addMedia($data['avatar'])->toMediaCollection('avatars');
        }

        return $user;
    }

    public function getUserByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function getUserById(string $id)
    {
        return User::find($id);
    }

    public function updateUser(User $user, array $data)
    {
        $user->update($data);

        return $user;
    }

    public function deleteUser(User $user)
    {
        return $user->delete();
    }

    public function getMeDetails(User $user)
    {
        return $user->load('media');
    }

    public function getUserPreferences(User $user)
    {
        return $user->preferences()->first();
    }

    public function updateUserPreferences(User $user, array $preferences)
    {
        $data = [
            'language' => $preferences['language'] ?? $user->preferences->language,
            'theme' => $preferences['theme'] ?? $user->preferences->theme,
            'timezone' => $preferences['timezone'] ?? $user->preferences->timezone,
            'email_notifications' => $preferences['email_notifications'] ?? $user->preferences->email_notifications,
            'sms_notifications' => $preferences['sms_notifications'] ?? $user->preferences->sms_notifications,
            'push_notifications' => $preferences['push_notifications'] ?? $user->preferences->push_notifications,
        ];

        $user->preferences()->updateOrCreate(['user_id' => $user->id], $data);
    }

    public function uploadUserAvatar(User $user, $avatar)
    {
        $user->clearMediaCollection('avatars');
        $user->addMedia($avatar)->toMediaCollection('avatars');
    }

    public function deleteUserAvatar(User $user)
    {
        $user->clearMediaCollection('avatars');
    }
}
