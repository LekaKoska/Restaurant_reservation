<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class ReviewService
{
    public function createReview(User $user, array $data): Review
    {
        $reservation = Reservation::findOrFail($data['reservation_id']);
        if($reservation->user_id !== $user->id)
        {
            throw new AuthorizationException("You are not owner of this reservation");
        }
        $review = Review::where("user_id", $user->id)->where("reservation_id", $reservation->id)->first();
        if (!is_null($review))
        {
             throw new ConflictHttpException(message: "Review already exists");
        }
        return $user->reviews()->create($data);
    }
}
