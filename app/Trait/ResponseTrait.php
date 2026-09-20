<?php

namespace App\Trait;

trait ResponseTrait
{
    /**
     * Return a success response.
     */
    public function successResponse(mixed $data, string $message = 'Operation completed successfully', $code = 200)
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
            'message' => $message,
            'data' => null
        ], $code);
    }

    /**
     * Return final Result if success or error
     */
    public function finalResponse(array $result) {
        if (!$result['success']) {
            return $this->errorResponse($result['message'], $result['code']);
        }

        return $this->successResponse($result['data'], $result['message'], $result['code']);
    }
}
