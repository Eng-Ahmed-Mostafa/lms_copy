<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Interface\Api\Auth\AuthInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ResponseTrait;
    protected ?AuthInterface $authService;

    public function __construct(AuthInterface $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $data = $this->authService->register($request->validated());

        return $this->successResponse($data, 'User registered successfully', 201);
    }

    public function login(LoginRequest $request)
    {
        $data = $this->authService->login($request->validated());

        if (!$data) {
            return $this->errorResponse('The provided credentials are incorrect.', 401);
        }

        return $this->successResponse($data, 'User logged in successfully');
    }

    public function logout(Request $request)
    {
        $result = $this->authService->logout($request);
        return $this->successResponse(null, $result['message']);
    }

    public function refreshToken()
    {
        $data = $this->authService->refreshToken();
        return $this->successResponse($data, 'Token refreshed successfully');
    }

    public function me(Request $request)
    {
        return $this->successResponse(['user' => $request->user()], 'User details retrieved successfully');
    }

    public function forgotPassword(ForgetPasswordRequest $request)
    {
        $data = $this->authService->forgotPassword($request->validated()['email']);

        if($data['success'] === false) {
            return $this->errorResponse($data['message']);
        }
        return $this->successResponse(null, $data['message']);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $this->authService->resetPassword($request->validated());
        return $this->successResponse(null, $data['message']);
    }

    public function verifyEmail(Request $request)
    {
        $result = $this->authService->verifyEmail($request->route('id'), $request->route('hash'));

        if(!$result['success']) {
            return $this->errorResponse($result['message']);
        }
        return $this->successResponse(null, $result['message']);
    }

    public function resendVerificationEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $result = $this->authService->resendVerificationEmail($validated['email']);
        if(!$result['success']) {
            return $this->errorResponse($result['message']);
        }
        return $this->successResponse(null, $result['message']);
    }

    public function getUserDevices(Request $request)
    {
        $devices = $this->authService->getUserDevices();
        return $this->successResponse($devices, 'User devices retrieved successfully');
    }

    public function revokeDevice(string $deviceId)
    {
        $result = $this->authService->revokeDevice($deviceId);
        if(!$result['success']) {
            return $this->errorResponse($result['message']);
        }
        return $this->successResponse(null, 'Device revoked successfully');
    }

    public function revokeAllDevices()
    {

        $result = $this->authService->revokeAllDevices();
        if(!$result['success']) {
            return $this->errorResponse($result['message']);
        }
        return $this->successResponse(null, 'All devices revoked successfully');
    }
}
