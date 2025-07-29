<?php

namespace App\Http\Controllers\Auth;

use http\Env\Response;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

class VerifyEmailController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/email/verify/{id}/{hash}",
     *     summary="Verify user email address",
     *     description="Used to verify user's email. Requires valid signed URL with query parameters `expires` and `signature`.",
     *     tags={"Auth"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="hash",
     *         in="path",
     *         required=true,
     *         description="Email verification hash (SHA1 of user's email)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="expires",
     *         in="query",
     *         required=true,
     *         description="Expiration timestamp of signed URL",
     *         @OA\Schema(type="integer", example=1753791260)
     *     ),
     *     @OA\Parameter(
     *         name="signature",
     *         in="query",
     *         required=true,
     *         description="Signature used to verify the signed URL",
     *         @OA\Schema(type="string", example="418f0fa...")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Email verified successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Email successfully verified.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Invalid or expired signature",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid signature")
     *         )
     *     )
     * )
     */

    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return response()->json(['message' => 'Email verified successfully.'], \Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }
}

