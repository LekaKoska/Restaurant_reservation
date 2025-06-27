<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

           $user = User::create([
                "name" => $request->get("name"),
                "email" => $request->get("email"),
                "password" => Hash::make($request->get("password")),
            ]);

            return response()->json([
                "success" => true,
                "message" => "Registered successfully",
                "data" => [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email
                ]
            ], 201);


    }

    public function login(LoginRequest $request)
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
        $token = $user->createToken('Api token of ' . $user->name)->plainTextToken;

        return response()->json([
            "success" => true,
            "message" => "Login successfully",
            "data" => [
                "id" => $user->id,
                "email" => $user->email,
            ],
            "token" => $token
        ], 200);

    }
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            "success" => true,
            "message" => "Logged out successfully and token has been deleted"
        ]);
    }
}
