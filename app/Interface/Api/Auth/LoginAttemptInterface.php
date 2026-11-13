<?php

namespace App\Interface\Api\Auth;

interface LoginAttemptInterface
{
    public function record(?int $userId, ?string $ipAddress, ?string $userAgent, bool $successful): void;
}
