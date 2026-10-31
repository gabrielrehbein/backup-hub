<?php

namespace App\Modules\Backups\Policies;

use App\Modules\Backups\Models\Backup;
use App\Modules\Users\Models\User;

/**
 * Os controllers autorizam pela classe (Backup::class), por isso o
 * parâmetro do model é opcional: as regras dependem só do papel do usuário.
 */
class BackupPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ?Backup $backup = null): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, ?Backup $backup = null): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, ?Backup $backup = null): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, ?Backup $backup = null): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, ?Backup $backup = null): bool
    {
        return $user->isAdmin();
    }
}
