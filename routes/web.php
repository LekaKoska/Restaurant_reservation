<?php
use App\Http\Controllers\EmailReviewController;
use Illuminate\Support\Facades\Route;


Route::patch("/review-email/comment", [EmailReviewController::class, "update"])->middleware("signed")->name("review-email.comment");

