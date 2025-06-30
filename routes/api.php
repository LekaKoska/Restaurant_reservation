<?php

use App\Http\Controllers\AuthController;
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


Route::post("/table", [ReservationController::class, "index"])->middleware("auth:sanctum");

Route::get("/allTables", [ReservationController::class, "info"]);
