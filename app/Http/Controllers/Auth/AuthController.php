<?php

namespace App\Http\Controllers\Auth;

use App\Services\ResponseServices;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Repository\AuthRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected AuthRepository $authUserRepo)
    {}
    public function register(RegisterRequest $request): JsonResponse
    {

           $user = $this->authUserRepo->register($request);

                event(new Registered($user));

            $verifyUrl = $this->authUserRepo->url($user);

            $token = $user->createToken('Api token of ' . $user->name)->plainTextToken;

           return ResponseServices::authSuccess(message: "Registered successfully", data: $user, verificationLink: $verifyUrl, token: $token);



    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only("email", "password");

        if(!Auth::attempt($credentials))
        {
           return ResponseServices::errorResponse(message: "Invalid credentials");

        }
        $user = User::where("email", $request->email)->first();


        $token = $user->createToken('Api token of ' . $user->name)->plainTextToken;

       return ResponseServices::authSuccess(message: "Login successfully", data: $user, token: $token);


    }
    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return ResponseServices::successResponse(message: "Logged out successfully and token has been deleted");

    }
}
