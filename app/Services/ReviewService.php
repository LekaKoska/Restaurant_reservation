<?php

namespace App\Services;

use App\DTOs\CreateReviewDTO;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
class ReviewService
{
    public function createReview(User $user, CreateReviewDTO $data): Review
    {
        $reservation = Reservation::findOrFail($data->reservationId);
        if($reservation->user_id !== $user->id)
        {
            throw new AuthorizationException("You are not owner of this reservation");
        }
        $review = Review::where("user_id", $user->id)->where("reservation_id", $reservation->id)->first();
        if (!is_null($review))
        {
             throw new ConflictHttpException(message: "Review already exists");
        }
        return $user->reviews()->create($data->toArray());
    }
}
