<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Review;
use App\Services\ResponseServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Framework\Exception;

class EmailReviewController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $reservation = Reservation::findOrFail($request->reservation_id);
        $review = Review::firstWhere("reservation_id", $reservation->id);
        try {
            if($review)
            {
                throw new Exception(message: "Review already exists!");
            }
            $newReview = Review::create([
                "reservation_id" => $request->reservation_id,
                "user_id" => $reservation->user_id,
                "rating" => $request->rating
            ]);
            return ResponseServices::successResponse(data: $newReview);
        } catch (\Exception $e)
        {
            return ResponseServices::errorResponse(message: $e->getMessage());
        }
    }

    public function update()
    {
       //
    }
}
