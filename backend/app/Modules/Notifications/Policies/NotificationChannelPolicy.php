<?php

namespace App\Modules\Notifications\Policies;

use App\Modules\Notifications\Models\NotificationChannel;
use App\Modules\Users\Models\User;

use Illuminate\Auth\Access\Response;

class NotificationChannelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, NotificationChannel $notificationChannel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, NotificationChannel $notificationChannel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, NotificationChannel $notificationChannel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, NotificationChannel $notificationChannel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, NotificationChannel $notificationChannel): bool
    {
        return false;
    }
}
