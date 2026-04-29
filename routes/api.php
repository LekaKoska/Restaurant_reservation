<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ReservationController;
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

Route::controller(ReservationController::class)->middleware(["auth:sanctum","email_verify"])->prefix("reservation")->group(function (){
    Route::post("/","store");
    Route::get('/all/{user}', "reservationHistory")->name("show.reservation");
    Route::delete("delete/{reservation}", "delete")->name("delete.reservation");
    Route::get("/show/{reservation}", "show")->name("show.reservation");
    Route::patch("/update/{reservation}", "update")->name("update.reservation");
    Route::get("/{table}/taken-slots", "takenSlots");
});



