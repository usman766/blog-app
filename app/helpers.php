<?php

use Illuminate\Http\JsonResponse;

/**
 * Helper function to return JSON responses.
 *
 * @param string $message
 * @param array $data
 * @param int $statusCode
 * @return JsonResponse
 */
function jsonResponse(string $message,  mixed $data = [], int $statusCode = 200): JsonResponse
{
    return response()->json([
        'message' => $message,
        'data' => $data,
    ], status: $statusCode);
}


/**
 * Handles repetitive try-catch exception handling.
 */
function handleRequest(callable $callback): JsonResponse
{
    try {
        return $callback();
    } catch (Exception $e) {
        return jsonResponse(__('messages.blog.error', ['error' => $e->getMessage()]), statusCode: 500);
    }
}
