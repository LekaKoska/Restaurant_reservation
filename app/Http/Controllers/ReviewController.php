<?php

namespace App\Http\Controllers;

use App\DTOs\CreateReviewDTO;
use App\Http\Requests\ReviewRequest;
use App\Models\Reservation;
use App\Models\Review;
use App\Services\ResponseServices;
use App\Services\ReviewService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        $this->authorizeResource(model: Review::class, parameter: "review");
    }
    public function index()
    {

    }
    public function store(ReviewRequest $request, ReviewService $reviewService)
    {
      $reviewDTO = CreateReviewDTO::fromRequest($request);
      $review = $reviewService->createReview(Auth::user(), $reviewDTO);
      return ResponseServices::successResponse(data: $review, message: "Successfully created Review");
    }
    public function show(Review $review)
    {
        //
    }
    public function update(Request $request, Review $review)
    {
        //
    }
    public function destroy(Review $review)
    {
        //
    }
}
