<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
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

    public function __invoke($id, EmailVerificationRequest $request)
    {
        $user = User::findOrFail($request->route('id'));
        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link');
        }
        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }
        return response()->json(['message' => 'Email verified successfully.']);
    }
 }

