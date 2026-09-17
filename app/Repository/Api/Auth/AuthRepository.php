<?php

namespace App\Repository\Api\Auth;

use App\Interface\Api\Auth\AuthInterface;
use App\Models\User;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Str;
use App\Notifications\Auth\VerifyEmailNotification;

class AuthRepository implements AuthInterface
{
    protected function createDevice(User $user, array $data)
    {
        $userAgent = request()->header('User-Agent');
        $deviceId = Str::uuid()->toString();
        $deviceName = $data['device_name'] ?? 'Unknown Device';
        $deviceType = $data['device_type'] ?? 'Unknown Type';
        $platform = $data['platform'] ?? 'Unknown Platform';
        $browser = $data['browser'] ?? 'Unknown Browser';
        $ipAddress = request()->ip();

        return $user->devices()->create([
            'device_id' => $deviceId,
            'device_name' => $deviceName,
            'device_type' => $deviceType,
            'platform' => $platform,
            'browser' => $browser,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'last_used_at' => now(),
        ]);

    }

    protected function createToken(User $user, $device = null)
    {
        $token = $user->createToken('api_token');

        $token->accessToken->update([
            'device_id' => $device->id,
        ]);

        return $token->plainTextToken;
    }

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

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        $device = $this->createDevice($user, $credentials);

        $token = $this->createToken($user, $device);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

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

        return [
            'success' => true,
            'message' => 'Logged out successfully.',
        ];
    }

    public function refreshToken()
    {
        $user = Auth::user();
        $token = $this->createToken($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function forgotPassword(string $email)
    {
        $status = Password::sendResetLink(['email' => $email]);
        if ($status === Password::RESET_LINK_SENT) {
            return [
                'success' => true,
                'message' => 'Password reset link sent to your email.',
            ];
        }
        return [
            'success' => false,
            'message' => 'Unable to send password reset link.',
        ];
    }

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
            return ['message' => 'Password has been reset successfully.'];
        } else {
            return ['message' => 'Unable to reset password.'];
        }
    }

    public function verifyEmail(string $id, string $hash)
    {
        $user = User::find($id);

        if (! $user) {
            return [
                'success' => false,
                'message' => 'User not found.',
            ];
        }

        if (! hash_equals(
            $hash,
            sha1($user->getEmailForVerification())
        )) {
            return [
                'success' => false,
                'message' => 'Invalid verification link.',
            ];
        }

        if ($user->hasVerifiedEmail()) {
            return [
                'success' => true,
                'message' => 'Email already verified.',
            ];
        }

        $user->markEmailAsVerified();

        return [
            'success' => true,
            'message' => 'Email verified successfully.',
        ];
    }

    public function resendVerificationEmail(string $email)
    {
        $user = User::where('email', $email)->first();

        if (! $user) {
            return [
                'success' => false,
                'message' => 'User not found.',
            ];
        }

        if ($user->hasVerifiedEmail()) {
            return [
                'success' => true,
                'message' => 'Email already verified.',
            ];
        }

        $user->sendEmailVerificationNotification();

        return [
            'success' => true,
            'message' => 'Verification email resent successfully.',
        ];
    }


    public function getUserDevices()
    {
        $user = Auth::user();

        $currentToken = $user->currentAccessToken();

        return $user->devices()
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
    }

    public function revokeDevice(string $deviceId)
    {
        $user = Auth::user();
        $device = $user->devices()->where('id', $deviceId)->first();

        if (! $device) {
            return [
                'success' => false,
                'message' => 'Device not found.',
            ];
        }

        $device->personalAccessTokens()->delete();
        $device->update([
            'revoked_at' => now(),
        ]);

        return [
            'success' => true,
            'message' => 'Device revoked successfully.',
        ];
    }

    public function revokeAllDevices()
    {
        $user = Auth::user();

        $user->tokens()->delete();

        $user->devices()->update([
            'revoked_at' => now(),
        ]);

        return [
            'success' => true,
            'message' => 'All devices revoked successfully.',
        ];
    }
}
