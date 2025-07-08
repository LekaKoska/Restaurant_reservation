<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ReservationController;
use App\Http\Middleware\EnsureEmailVerified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix("/auth")->controller(AuthController::class)->group( function ()
{
    Route::post("/register",  "register");

    Route::post("/login",  "login");

    Route::post("/logout",  "logout")->middleware("auth:sanctum");
});


Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'Verification link sent!']);
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');

Route::post("/reservation", [ReservationController::class, "index"])->middleware("auth:sanctum", EnsureEmailVerified::class);

Route::get("/tables", [ReservationController::class, "info"]);

