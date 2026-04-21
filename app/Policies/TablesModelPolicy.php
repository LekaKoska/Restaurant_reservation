<?php

namespace App\Policies;

use App\Models\TablesModel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TablesModelPolicy
{

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, TablesModel $tablesModel): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, TablesModel $tablesModel): bool
    {
        return false;
    }
    public function delete(User $user, TablesModel $tablesModel): bool
    {
        return $user->id === $tablesModel->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TablesModel $tablesModel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TablesModel $tablesModel): bool
    {
        return false;
    }
}
