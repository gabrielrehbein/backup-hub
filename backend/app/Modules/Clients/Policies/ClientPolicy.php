<?php

namespace App\Modules\Clients\Policies;

use App\Modules\Clients\Models\Client;
use App\Modules\Users\Models\User;

/**
 * Os controllers autorizam pela classe (Client::class), por isso o
 * parâmetro do model é opcional: as regras dependem só do papel do usuário.
 */
class ClientPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, ?Client $client = null): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, ?Client $client = null): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, ?Client $client = null): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, ?Client $client = null): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, ?Client $client = null): bool
    {
        return $user->isAdmin();
    }
}
