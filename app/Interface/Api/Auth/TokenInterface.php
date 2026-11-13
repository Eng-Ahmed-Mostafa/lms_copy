<?php

namespace App\Interface\Api\Auth;

use App\Models\User;

interface TokenInterface
{
    public function createToken(User $user, $device = null);
}
