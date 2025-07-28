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
use OpenApi\Annotations as OA;

class AuthController extends Controller
{

    public function __construct(protected AuthRepository $authUserRepo)
    {}

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="Register new user",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="John"),
     *             @OA\Property(property="email", type="string", example="john@gmail.com"),
     *             @OA\Property(property="password", type="string", example="Password123"),
     *             @OA\Property(property="password_confirmation", type="string", example="Password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="New user has been created",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="verification_url", type="string", format="url"),
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Content",
     *     @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Error"),
     *     )
     *     ),
     * )
     */


    public function register(RegisterRequest $request): JsonResponse
    {

           $user = $this->authUserRepo->register($request);

                event(new Registered($user));

            $verifyUrl = $this->authUserRepo->url($user);

            $token = $user->createToken('Api token of ' . $user->name)->plainTextToken;

           return ResponseServices::authSuccess(message: "Registered successfully", data: $user, verificationLink: $verifyUrl, token: $token);



    }
    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Login exist user",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *     @OA\Property(property="email", type="string", example="exist@gmail.com"),
     *     @OA\Property(property="password", type="string", example="Password123"),
     *      )
     *       ),
     *     @OA\Response(
     *         response=200,
     *         description="Logged succsesfully",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="success")
     *     )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Invalid Credentials",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Invalid email or password")
     *     )
     *     )
     * )
     *
     *
     */

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

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Logout function",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logged out successfully",
     *     @OA\JsonContent(
     *         @OA\Property(
     *             property="message", type="string", example="Logged out successfully")
     *     )
     *     )
     * )
     */

    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return ResponseServices::successResponse(message: "Logged out successfully and token has been deleted");

    }
}
