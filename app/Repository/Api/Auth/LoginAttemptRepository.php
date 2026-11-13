<?php

namespace App\Repository\Api\Auth;

use App\Interface\Api\Auth\LoginAttemptInterface;
use App\Models\LoginAttempts;

class LoginAttemptRepository implements LoginAttemptInterface
{
    public function record(?int $userId, ?string $ipAddress, ?string $userAgent, bool $successful): void
    {
        LoginAttempts::create([
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'successful' => $successful,
            'attempted_at' => now(),
        ]);
    }
}
