<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
class ApiResponse
{
    public static function successResponse($status = true, string $message = null, $data = null, int $code = 200): JsonResponse
    {
        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => $data
        ], $code);
    }

    public static function errorResponse($status = false, string $message = "error", int $code = 403): JsonResponse
    {
        return response()->json(
            [
                "status" => $status,
                "message" => $message
            ], $code);
    }

}
