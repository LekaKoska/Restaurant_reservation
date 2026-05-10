<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

class ReviewService
{
    public function createReview(User $user, array $data)
    {
        $reservation = Reservation::findOrFail($data['reservation_id']);
        if($reservation->user_id !== $user->id)
        {
            throw new AuthorizationException("You are not owner of this reservation");
        }
        $data['user_id'] = $user->id;
        return Review::create($data);
    }
}
