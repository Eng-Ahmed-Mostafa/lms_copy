<?php

namespace App\Repository\Api\Auth;

use App\Interface\Api\Auth\AuthInterface;
use App\Models\User;
use App\Models\Device;
use App\Models\LoginAttempts;
use App\Trait\RepositoryTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthRepository implements AuthInterface
{
    use RepositoryTrait;

    //  create a new device for the user
    protected function createDevice(User $user, array $data)
    {
        $device = $user->devices()->create([
            'device_id' => Str::uuid()->toString(),
            'device_name' => $data['device_name'] ?? 'Unknown Device',
            'device_type' => $data['device_type'] ?? 'Unknown Type',
            'platform' => $data['platform'] ?? 'Unknown Platform',
            'browser' => $data['browser'] ?? 'Unknown Browser',
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'last_used_at' => now(),
        ]);

        return $device;
    }

    //  create a new token for the user and associate it with the device
    protected function createToken(User $user, $device = null)
    {
        $token = $user->createToken('api_token');

        $token->accessToken->update([
            'device_id' => $device->id,
        ]);

        return $token->plainTextToken;
    }

    //  create a new login attempt record
    public function createLoginAttempt(?User $user, string $ipAddress, string $userAgent, bool $successful)
    {
        return LoginAttempts::create([
            'user_id' => $user ? $user->id : null,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'successful' => $successful,
            'attempted_at' => now(),
        ]);
    }

    //  register a new user
    public function register(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
            'avatar' => $data['avatar'] ?? null,
            'gender' => $data['gender'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'status' => $data['status'] ?? 'active',
        ]);

        $user->sendEmailVerificationNotification();

        $device = $this->createDevice($user, $data);
        $token = $this->createToken($user, $device);

        $data = [
            'user' => $user,
            'token' => $token,
        ];

        return $this->returnData(true, 'User registered successfully', 201, $data);
    }

    //  login a user and return a token
    public function login(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return $this->returnData(false, 'The provided credentials are incorrect.', 401);
        }

        $device = $this->createDevice($user, $credentials);
        $user->sendLoginFromDeviceNotification($device->id);

        $token = $this->createToken($user, $device);

        $loginAttempt = $this->createLoginAttempt($user, request()->ip(), request()->header('User-Agent'), true);

        $data = [
            'user' => $user,
            'token' => $token,
            'device' => $device,
            'login_attempt' => $loginAttempt,
        ];

        return $this->returnData(true, 'User logged in successfully', 200, $data);
    }

    //  logout a user and invalidate the token
    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();

        if ($token) {
            $device = $token->device;

            $token->delete();

            if ($device) {
                $device->update([
                    'revoked_at' => now(),
                ]);
            }
        }

        return $this->returnData(true, 'Logged out successfully.', 200);
    }

    //  refresh the token
    public function refreshToken()
    {
        $user = Auth::user();

        $currentToken = $user->currentAccessToken();

        if(! $currentToken) {
            return $this->returnData(false, 'No active token found.', 401);
        }

        $device = $currentToken->device;

        if (! $device) {
            return $this->returnData(false, 'No associated device found for the current token.', 404);
        }

        $currentToken->delete();

        $token = $this->createToken($user, $device);

        $data = [
            'user' => $user,
            'token' => $token,
        ];

        return $this->returnData(true, 'Token refreshed successfully.', 200, $data);
    }

    //  get the authenticated user's details
    public function me(Request $request)
    {
        return $this->returnData(true, 'User details retrieved successfully.', 200, ['user' => Auth::user()]);
    }

    //  send a password reset link to the user
    public function forgotPassword(string $email)
    {
        $status = Password::sendResetLink(['email' => $email]);
        if ($status === Password::RESET_LINK_SENT) {
            return $this->returnData(true, 'Password reset link sent successfully.', 200);
        }

        return $this->returnData(false, 'Unable to send password reset link.', 400);
    }

    //  reset the user's password
    public function resetPassword(array $data)
    {
        $status = Password::reset(
            $data,
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return $this->returnData(true, 'Password has been reset successfully.', 200);
        } else {
            return $this->returnData(false, 'Unable to reset password.', 400);
        }
    }

    //  verify the user's email
    public function verifyEmail(string $id, string $hash)
    {
        $user = User::find($id);

        if (! $user) {
            return $this->returnData(false, 'User not found.', 404);
        }

        if (! hash_equals(
            $hash,
            sha1($user->getEmailForVerification())
        )) {
            return $this->returnData(false, 'Invalid verification link.', 400);
        }

        if ($user->hasVerifiedEmail()) {
            return $this->returnData(true, 'Email already verified.', 200);
        }

        $user->markEmailAsVerified();

        return $this->returnData(true, 'Email verified successfully.', 200);
    }

    //  resend the email verification link to the user
    public function resendVerificationEmail(string $email)
    {
        $user = User::where('email', $email)->first();

        if (! $user) {
            return $this->returnData(false, 'User not found.', 404);
        }

        if ($user->hasVerifiedEmail()) {
            return $this->returnData(true, 'Email already verified.', 200);
        }

        $user->sendEmailVerificationNotification();

        return $this->returnData(true, 'Verification email resent successfully.', 200);
    }

    //  get the authenticated user's devices
    public function getUserDevices()
    {
        $user = Auth::user();

        $currentToken = $user->currentAccessToken();

        $data = $user->devices()
            ->get()
            ->map(function ($device) use ($currentToken) {
                return [
                    'id' => $device->id,
                    'device_id' => $device->device_id,
                    'user_id' => $device->user_id,
                    'device_name' => $device->device_name,
                    'device_type' => $device->device_type,
                    'platform' => $device->platform,
                    'browser' => $device->browser,

                    'ip_address' => $device->ip_address,

                    'is_current' => $currentToken
                        && $currentToken->device_id === $device->id,

                    'last_used_at' => $device->last_used_at
                        ? $device->last_used_at->diffForHumans()
                        : null,

                    'created_at' => $device->created_at
                        ? $device->created_at->format('Y-m-d H:i:s')
                        : null,

                    'revoked_at' => $device->revoked_at,
                ];
            })
            ->values()
            ->toArray();
        return $this->returnData(true, 'Devices retrieved successfully.', 200, $data);
    }

    //  revoke a specific device for the authenticated user
    public function revokeDevice(string $deviceId)
    {
        $user =  Auth::user();
        $device = $user->devices()->where('id', $deviceId)->first();

        if (! $device) {
            return $this->returnData(false, 'Device not found.', 404);
        }

        $device->personalAccessTokens()->delete();
        $device->update([
            'revoked_at' => now(),
        ]);

        return $this->returnData(true, 'Device revoked successfully.', 200);
    }

    //  revoke all devices for the authenticated user
    public function revokeAllDevices()
    {
        $user = Auth::user();

        $user->tokens()->delete();

        $user->devices()->update([
            'revoked_at' => now(),
        ]);

        return $this->returnData(true, 'All devices revoked successfully.', 200);
    }
}
