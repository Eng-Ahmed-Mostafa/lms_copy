<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Auth\PasswordServices;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    use ResponseTrait;
    public function __construct(private readonly PasswordServices $passwordServices) {}
    // forgot password endpoint to send a password reset link to the user's email
    public function forgotPassword(EmailRequest $request)
    {
        $data = $request->validated();

        $result = $this->passwordServices->forgetPassword($data['email']);

        return $this->finalResponse($result);
    }

    // reset password endpoint to reset the user's password
    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->validated();

        $result = $this->passwordServices->resetPassword($data);

        return $this->finalResponse($result);
    }
}
