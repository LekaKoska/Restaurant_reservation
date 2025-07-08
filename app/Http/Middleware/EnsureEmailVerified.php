<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if($user && ! $user->hasVerifiedEmail())
        {

            $verificationUrl = URL::temporarySignedRoute(
                "verification.verify",
                Carbon::now()->addMinute(60),
                ["id" => $user->id, "hash" => sha1($user->email)]
            );

            return response()->json(
                [
                    "message" => "Email not verified",
                    "verify_link" => $verificationUrl
                ], 403);


        }


        return $next($request);
    }
}
