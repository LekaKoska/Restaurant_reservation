<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use App\Traits\OwnsResource;


class ReservationPolicy
{
    use OwnsResource;

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Reservation $reservation): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Reservation $reservation): bool
    {
        return $this->isOwner($user, $reservation);
    }
    public function delete(User $user, Reservation $reservation): bool
    {
        return $this->isOwner($user, $reservation);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Reservation $reservation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Reservation $Reservation): bool
    {
        return false;
    }
}
