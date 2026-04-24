<?php

namespace App\Traits;

use App\Models\User;

trait OwnsResource
{
    public function isOwner(User $user, $model): bool
    {
        return $user->id === $model->user_id;
    }
}
