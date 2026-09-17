<?php

namespace App\Interface\Api\Auth;

use Illuminate\Http\Request;

interface AuthInterface
{
    public function register(array $data);
    public function login(array $credentials);
    public function logout(Request $request);
    public function refreshToken();
    public function forgotPassword(string $email);
    public function resetPassword(array $data);
    public function verifyEmail(string $id, string $hash);
    public function resendVerificationEmail(string $email);
    public function getUserDevices();
    public function revokeDevice(string $deviceId);
    public function revokeAllDevices();
}
