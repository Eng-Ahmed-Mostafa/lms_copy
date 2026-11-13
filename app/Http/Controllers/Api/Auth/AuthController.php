<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Services\Access\DeviceServices;
use App\Services\Auth\AuthServices;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthServices $authServices,
        private DeviceServices $deviceServices
    ) {}

    //  register a new user and send email verification
    public function register(RegisterRequest $request)
    {
        $device = $request->device();

        $deviceData = $this->deviceServices->getDeviceDataFromDevice($device);

        $data = $request->validated();

        $result = $this->authServices->registerUser($data, $deviceData);

        if (!$result['user']) {
            return response()->json([
                'message' => 'User registration failed',
            ], 500);
        }

        return UserResource::make($result['user'])->additional([
            'token' => $result['token'],
        ]);
    }

    // login user and create a new token for the user and associate it with the device
    public function login(LoginRequest $request)
    {
        $device = $request->device();

        $deviceData = $this->deviceServices->getDeviceDataFromDevice($device);

        $data = $request->validated();

        $result = $this->authServices->loginUser($data, $deviceData);

        if (!$result['user']) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        return UserResource::make($result['user'])->additional([
            'token' => $result['token'],
        ]);
    }

    // logout user and revoke the token
    public function logout(Request $request)
    {
        $result = $this->authServices->logoutUser($request);

        if (!$result) {
            return response()->json([
                'message' => 'Logout failed',
            ], 500);
        }

        return response()->json([
            'message' => 'Logout successful',
        ]);
    }

    // me endpoint to get the authenticated user's details
    public function me(Request $request)
    {
        $result = $this->authServices->me($request);

        if (!$result) {
            return response()->json([
                'message' => 'Failed to retrieve user details',
            ], 500);
        }

        return UserResource::make($result['user']);
    }


}
