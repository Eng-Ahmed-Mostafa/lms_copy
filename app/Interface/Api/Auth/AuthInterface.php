<?php

namespace App\Interface\Api\Auth;

use Illuminate\Http\Request;

interface AuthInterface
{
    //  user authentication and authorization management
    public function register(array $data);
    public function login(array $credentials);
    public function logout(Request $request);
    public function refreshToken();
    public function me(Request $request);

    // Password reset and email verification management
    public function forgotPassword(string $email);
    public function resetPassword(array $data);
    public function verifyEmail(string $id, string $hash);
    public function resendVerificationEmail(string $email);

    //  device management
    public function getUserDevices();
    public function revokeDevice(string $deviceId);
    public function revokeAllDevices();
}
