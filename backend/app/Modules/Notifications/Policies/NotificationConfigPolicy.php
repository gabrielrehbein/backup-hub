<?php

namespace App\Modules\Notifications\Policies;

use App\Modules\Notifications\Models\NotificationConfig;
use App\Modules\Users\Models\User;

/**
 * Os controllers autorizam pela classe (NotificationConfig::class), por isso o
 * parâmetro do model é opcional: as regras dependem só do papel do usuário.
 */
class NotificationConfigPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, ?NotificationConfig $notificationConfig = null): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, ?NotificationConfig $notificationConfig = null): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, ?NotificationConfig $notificationConfig = null): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, ?NotificationConfig $notificationConfig = null): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, ?NotificationConfig $notificationConfig = null): bool
    {
        return $user->isAdmin();
    }
}
