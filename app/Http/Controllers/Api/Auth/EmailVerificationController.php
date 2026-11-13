<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\EmailVerificationService;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function __construct(private readonly EmailVerificationService $emailVerificationService) {}

    public function verify(string $id, string $hash)
    {
        $user = User::findOrFail($id);

        $result = $this->emailVerificationService->verifyEmail($user, $id, $hash);

        return response()->json([
            'success' => true,
            ...$result,
        ]);
    }

    public function resend(Request $request)
    {
        $user = $request->user();

        $result = $this->emailVerificationService->resend($user);

        return response()->json([
            'success' => true,
            ...$result,
        ]);
    }
}
