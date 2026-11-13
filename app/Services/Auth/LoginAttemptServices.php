<?php

namespace App\Services\Auth;

use App\Interface\Api\Auth\LoginAttemptInterface;

class LoginAttemptServices
{
    public function __construct(private LoginAttemptInterface $loginAttempt) {}

    public function recordLoginAttempt(?int $userId, ?string $ipAddress, ?string $userAgent, bool $successful): void
    {
        $this->loginAttempt->record($userId, $ipAddress, $userAgent, $successful);
    }
}
