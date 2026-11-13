<?php

namespace App\Repository\Api\Auth;

use App\Interface\Api\Auth\PasswordInterface;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordRepository implements PasswordInterface
{
    public function sendResetLink(string $email)
    {
        return Password::sendResetLink(['email' => $email]);
    }


    public function resetPassword(array $data)
    {
        $status = Password::reset(
            $data,
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status;
    }


    public function checkPassword(string $password, string $hashedPassword): bool
    {
        return Hash::check($password, $hashedPassword);
    }
}
