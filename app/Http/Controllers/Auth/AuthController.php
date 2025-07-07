<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {

           $user = User::create([
                "name" => $request->get("name"),
                "email" => $request->get("email"),
                "password" => Hash::make($request->get("password")),
            ]);

                event(new Registered($user));

            $verifyUrl = URL::temporarySignedRoute(
                "verification.verify",
                Carbon::now()->addMinute(60),
                ["id" => $user->id, "hash" => sha1($user->email)]
                );
        $token = $user->createToken('Api token of ' . $user->name)->plainTextToken;

            return response()->json([
                "success" => true,
                "message" => "Registered successfully",
                "verification_link" => $verifyUrl,
                "data" => [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email
                ],
                "token" => $token
            ], 201);


    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only("email", "password");

        if(!Auth::attempt($credentials))
        {
            return response()->json([
                'success' => false,
                'message' => "Invalid credentials"
            ], 401);
        }
        $user = User::where("email", $request->email)->first();


        return response()->json([
            "success" => true,
            "message" => "Login successfully",
            "data" => [
                "id" => $user->id,
                "email" => $user->email,
            ]

        ], 200);

    }
    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            "success" => true,
            "message" => "Logged out successfully and token has been deleted"
        ]);
    }
}
