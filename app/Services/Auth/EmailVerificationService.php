<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Validation\ValidationException;

class EmailVerificationService
{
    public function verifyEmail(User $user, string $id, string $hash): array
    {
        if ((string) $user->id !== $id) {
            throw ValidationException::withMessages([
                'user' => ['Invalid verification user'],
            ]);
        }



        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            throw ValidationException::withMessages([
                'hash' => ['Invalid verification hash'],
            ]);
        }

        if ($user->hasVerifiedEmail()) {
            return [
                'message' => 'Email already verified',
            ];
        }

        $user->markEmailAsVerified();

        return [
            'message' => 'Email verified successfully',
        ];
    }


    public function resend(User $user): array
    {
        if ($user->hasVerifiedEmail()) {
            return [
                'message' => 'Email already verified',
            ];
        }

        $user->sendEmailVerificationNotification();

        return [
            'message' => 'Verification email resent successfully',
        ];
    }

}
