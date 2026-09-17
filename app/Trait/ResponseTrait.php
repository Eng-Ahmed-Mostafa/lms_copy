<?php

namespace App\Trait;

trait ResponseTrait
{
    /**
     * Return a success response.
     */
    public function successResponse(?array $data, string $message = 'Operation completed successfully', $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Return an error response.
     */
    public function errorResponse(string $message = 'An error occurred', $code = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }
}
