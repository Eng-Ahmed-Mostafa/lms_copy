<?php

namespace App\Services\Auth;

use App\Interface\Api\Auth\TokenInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TokenServices
{
    public function __construct(private TokenInterface $token) {}

    public function createToken($user, $device = null)
    {
        return $this->token->createToken($user, $device);
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();

        $currentToken = $user->currentAccessToken();

        if (!$currentToken) {
            return throw ValidationException::withMessages([
                'token' => ['No active token found.'],
            ]);
        }

        $device = $currentToken->device;

        // Revoke the current token
        $currentToken->delete();

        // Create a new token
        $newToken = $this->token->createToken($user, $device);

        return [
            'message' => 'Token refreshed successfully',
            'token' => $newToken,
            'device' => $device,
        ];
    }
}
