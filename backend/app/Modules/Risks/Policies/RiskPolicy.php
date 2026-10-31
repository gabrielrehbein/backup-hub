<?php

namespace App\Modules\Risks\Policies;

use App\Modules\Risks\Models\Risk;
use App\Modules\Users\Models\User;

/**
 * Os controllers autorizam pela classe (Risk::class), por isso o
 * parâmetro do model é opcional: as regras dependem só do papel do usuário.
 */
class RiskPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, ?Risk $risk = null): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, ?Risk $risk = null): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, ?Risk $risk = null): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, ?Risk $risk = null): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, ?Risk $risk = null): bool
    {
        return $user->isAdmin();
    }
}
