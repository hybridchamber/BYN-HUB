<?php

namespace App\Policies;

use App\Models\YouthProfile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class YouthProfilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view any profile') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, YouthProfile $youthProfile): bool
    {
        return $user->hasPermissionTo('view profile') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create profile') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, YouthProfile $youthProfile): bool
    {
        return $user->hasPermissionTo('update profile') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, YouthProfile $youthProfile): bool
    {
        return $user->hasPermissionTo('delete profile') ? true : false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, YouthProfile $youthProfile): bool
    {
        return $user->hasPermissionTo('restore profile') ? true : false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, YouthProfile $youthProfile): bool
    {
        return $user->hasPermissionTo('force delete profile') ? true : false;
    }
}
