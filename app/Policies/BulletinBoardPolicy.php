<?php

namespace App\Policies;

use App\Models\BulletinBoard;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BulletinBoardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view any bulletinboard') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BulletinBoard $bulletinBoard): bool
    {
        return $user->hasPermissionTo('view bulletinboard') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create bulletinboard') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BulletinBoard $bulletinBoard): bool
    {
        return $user->hasPermissionTo('update bulletinboard') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BulletinBoard $bulletinBoard): bool
    {
        return $user->hasPermissionTo('delete bulletinboard') ? true : false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BulletinBoard $bulletinBoard): bool
    {
        return $user->hasPermissionTo('restore bulletinboard') ? true : false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BulletinBoard $bulletinBoard): bool
    {
        return $user->hasPermissionTo('force delete bulletinboard') ? true : false;
    }
}
