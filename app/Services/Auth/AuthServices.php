<?php

namespace App\Services\Auth;

use App\Events\Auth\UserRegistered;
use App\Interface\Api\User\UserInterface;
use App\Models\User;
use App\Services\Access\DeviceServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AuthServices
{
    public function __construct(
        protected readonly DeviceServices $device,
        protected readonly UserInterface $user,
        protected readonly LoginAttemptServices $loginAttempt,
        protected readonly PasswordServices $password,
        protected readonly TokenServices $token
    ) {}

    //* Main Methods
    //  register a new user and send email verification
    public function registerUser(array $data, array $deviceData)
    {
        $result = DB::transaction(function () use ($data, $deviceData) {
            $user = $this->user->createUser($data);

            $device = $this->device->createDevice($user, $deviceData);

            $token = $this->token->createToken($user, $device);

            DB::afterCommit(function () use ($user) {
                event(new UserRegistered($user));
            });
            return [
                'user' => $user,
                'token' => $token,
                'device' => $device,
            ];
        });


        return $result;
    }

    public function loginUser(array $data, array $deviceData)
    {
        try {
            return DB::transaction(function () use ($data, $deviceData) {
                $user = $this->user->getUserByEmail($data['email']);

                if (!$user) {
                    $this->loginAttempt->recordLoginAttempt(null, $deviceData['ip_address'] ?? null, $deviceData['user_agent'] ?? null, false);

                    throw ValidationException::withMessages([
                        'email' => ['The provided credentials are incorrect.'],
                    ]);
                }

                $checkPassword = $this->password->checkPassword($data['password'], $user->password);

                if (!$checkPassword) {
                    $this->loginAttempt->recordLoginAttempt($user->id, request()->ip(), request()->header('User-Agent'), false);
                    return throw ValidationException::withMessages([
                        'email' => ['The provided credentials are incorrect.'],
                    ]);
                }

                $device = $this->device->createDevice($user, $deviceData);
                $user->sendLoginFromDeviceNotification($device->id);

                $token = $this->token->createToken($user, $device);

                $this->loginAttempt->recordLoginAttempt($user->id, request()->ip(), request()->header('User-Agent'), true);

                return [
                    'user' => $user,
                    'token' => $token,
                    'device' => $device,
                ];
            });
        } catch (\Exception $e) {
            // Handle the exception or log it
            return [
                'user' => null,
                'token' => null,
                'device' => null,
                'login_attempt' => null,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function logoutUser(Request $request)
    {
        $user = $request->user();

        $token = $user->currentAccessToken();

        if ($token) {
            $device = $token->device;

            $token->delete();

            if ($device) {
                $device->update([
                    'revoked_at' => now(),
                ]);
            }

            return [
                'message' => 'User logged out successfully',
                'device' => $device,
            ];
        } else {
            return [
                'message' => 'No active token found for the user',
            ];
        }
    }

    public function me(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return throw ValidationException::withMessages([
                'user' => ['No authenticated user found.'],
            ]);
        }

        return [
            'user' => $user,
        ];
    }
}
