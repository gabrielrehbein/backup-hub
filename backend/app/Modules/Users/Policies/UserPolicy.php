<?php

namespace App\Modules\Users\Policies;

use App\Modules\Users\Models\User;

/**
 * Os controllers autorizam pela classe (User::class), por isso o
 * parâmetro do model é opcional: as regras dependem só do papel do usuário.
 */
class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, ?User $model = null): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, ?User $model = null): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, ?User $model = null): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, ?User $model = null): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, ?User $model = null): bool
    {
        return $user->isAdmin();
    }
}
