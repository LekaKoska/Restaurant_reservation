<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix("/auth")->controller(AuthController::class)->group(function () {
    Route::post("/register",  "register");
    Route::post("/login",  "login");
    Route::post("/logout",  "logout")->middleware("auth:sanctum");
});

Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'Verification link sent!']);
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');

Route::middleware(["auth:sanctum", "email_verify"])->group(function ()
{
    Route::get(uri: "/tables", action: [ReservationController::class, "info"]);
    Route::controller(ReservationController::class)->prefix(prefix: "reservation")->group(function () {
        Route::post(uri: "/", action: "store");
        Route::get(uri: '/all/{user}', action: "reservationHistory")->name(name: "show.reservation");
        Route::delete(uri: "delete/{reservation}", action: "delete")->name(name: "delete.reservation");
        Route::get(uri: "/show/{reservation}", action: "show")->name(name: "show.reservation");
        Route::patch(uri: "/update/{reservation}", action: "update")->name(name: "update.reservation");
        Route::get(uri: "/{table}/taken-slots", action: "takenSlots");
    });
    Route::apiResource(name: "review", controller: ReviewController::class);
});

