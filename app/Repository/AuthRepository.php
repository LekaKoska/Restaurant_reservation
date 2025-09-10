<?php
namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class AuthRepository
{
    public function __construct(protected User $authUserModel)
    {}
    public  function register($request): User
    {
        return User::create([
            "name" => $request->get("name"),
            "email" => $request->get("email"),
            "password" => Hash::make($request->get("password")),
        ]);
    }

    public function url($user): string
    {
        return URL::temporarySignedRoute(
            "verification.verify",
            Carbon::now()->addMinute(60),
            ["id" => $user->id, "hash" => sha1($user->email)]
        );
    }
}
