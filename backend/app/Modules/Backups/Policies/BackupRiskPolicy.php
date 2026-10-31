<?php

namespace App\Modules\Backups\Policies;

use App\Modules\Backups\Models\BackupRisk;
use App\Modules\Users\Models\User;

/**
 * Os controllers autorizam pela classe (BackupRisk::class), por isso o
 * parâmetro do model é opcional: as regras dependem só do papel do usuário.
 */
class BackupRiskPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ?BackupRisk $backupRisk = null): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, ?BackupRisk $backupRisk = null): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, ?BackupRisk $backupRisk = null): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, ?BackupRisk $backupRisk = null): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, ?BackupRisk $backupRisk = null): bool
    {
        return $user->isAdmin();
    }
}
