<?php

namespace App\Modules\Systems\Policies;

use App\Modules\Systems\Models\System;
use App\Modules\Users\Models\User;

/**
 * Os controllers autorizam pela classe (System::class), por isso o
 * parâmetro do model é opcional: as regras dependem só do papel do usuário.
 */
class SystemPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ?System $system = null): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, ?System $system = null): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, ?System $system = null): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, ?System $system = null): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, ?System $system = null): bool
    {
        return $user->isAdmin();
    }
}
