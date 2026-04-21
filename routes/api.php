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
    ->middleware(['signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'Verification link sent!']);
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');

Route::get("/tables", [ReservationController::class, "info"]);

Route::controller(ReservationController::class)->middleware(["auth:sanctum", EnsureEmailVerified::class])->prefix("reservation")->group(function (){
    Route::post("/","index");
    Route::get('/show', "reservationHistory");
    Route::delete("delete/{id}", "delete")->name("delete.reservation");

});



