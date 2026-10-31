<?php

namespace App\Modules\Clients\Policies;

use App\Modules\Clients\Models\Plan;
use App\Modules\Users\Models\User;

/**
 * Os controllers autorizam pela classe (Plan::class), por isso o
 * parâmetro do model é opcional: as regras dependem só do papel do usuário.
 */
class PlanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, ?Plan $plan = null): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, ?Plan $plan = null): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, ?Plan $plan = null): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, ?Plan $plan = null): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, ?Plan $plan = null): bool
    {
        return $user->isAdmin();
    }
}
