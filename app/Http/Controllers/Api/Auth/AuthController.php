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

    // register a new user
    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());

        return $this->finalResponse($result);
    }

    // login a user and return a token
    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        return $this->finalResponse($result);
    }

    // logout a user and invalidate the token
    public function logout(Request $request)
    {
        $result = $this->authService->logout($request);
        return $this->finalResponse($result);
    }

    // refresh the token
    public function refreshToken()
    {
        $result = $this->authService->refreshToken();
        return $this->finalResponse($result);
    }

    // get the authenticated user's details
    public function me(Request $request)
    {
        $result = $this->authService->me($request);
        return $this->finalResponse($result);
    }

    // send a password reset link to the user
    public function forgotPassword(ForgetPasswordRequest $request)
    {
        $result = $this->authService->forgotPassword($request->validated()['email']);

        return $this->finalResponse($result);
    }

    // reset the user's password
    public function resetPassword(ResetPasswordRequest $request)
    {
        $result = $this->authService->resetPassword($request->validated());
        return $this->finalResponse($result);
    }

    // verify the user's email
    public function verifyEmail(Request $request)
    {
        $result = $this->authService->verifyEmail($request->route('id'), $request->route('hash'));

        if(!$result['success']) {
            return $this->errorResponse($result['message']);
        }
        return $this->successResponse(null, $result['message']);
    }

    // resend the email verification link to the user
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

    // get the authenticated user's devices
    public function getUserDevices()
    {
        $result = $this->authService->getUserDevices();
        return $this->finalResponse($result);
    }

    // revoke a specific device for the authenticated user
    public function revokeDevice(string $deviceId)
    {
        $result = $this->authService->revokeDevice($deviceId);
        return $this->finalResponse($result);
    }

    // revoke all devices for the authenticated user
    public function revokeAllDevices()
    {
        $result = $this->authService->revokeAllDevices();
        return $this->finalResponse($result);
    }
}
