<?php

namespace App\Repository\Api\Auth;

use App\Interface\Api\Auth\TokenInterface;
use App\Models\User;

class TokenRepository implements TokenInterface
{
    public function createToken(User $user, $device = null)
    {
        $token = $user->createToken('api_token');

        if ($device) {
            $token->accessToken->update([
                'device_id' => $device->id,
            ]);
        }

        return $token->plainTextToken;
    }
}
