<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\TokenServices;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function __construct(private readonly TokenServices $tokenServices) {}
    // refresh the token and return a new token
    public function refreshToken(Request $request)
    {
        $result = $this->tokenServices->refreshToken($request);

        if (!$result) {
            return response()->json([
                'message' => 'Token refresh failed',
            ], 500);
        }

        return response()->json([
            'token' => $result,
        ]);
    }
}
