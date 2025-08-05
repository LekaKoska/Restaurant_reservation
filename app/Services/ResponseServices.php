<?php
namespace App\Services;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseServices
{
    public static function successResponse($status = true, string $message = null, $data = null, int $code = Response::HTTP_CREATED): JsonResponse
    {
        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => $data
        ], $code);
    }

    public static function errorResponse($status = false, string $message = "error", int $code = Response::HTTP_FORBIDDEN): JsonResponse
    {
        return response()->json(
            [
                "status" => $status,
                "message" => $message
            ], $code);
    }
    public static function authSuccess($status = true, string $message = null, $data = null, string $verificationLink = null, string $token = null, int $code = Response::HTTP_CREATED): JsonResponse
    {
        return response()->json(
            [
                "status" => $status,
                "message" => $message,
                "data" => $data,
                "verification_link" => $verificationLink,
                "token" => $token
            ], $code);
    }
}
