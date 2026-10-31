<?php

namespace App\Modules\Backups\Policies;

use App\Modules\Backups\Models\BackupError;
use App\Modules\Backups\Models\BackupRisk;
use App\Modules\Users\Models\User;
use Illuminate\Auth\Access\Response;

class BackupRiskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return True;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BackupRisk $backupError): bool
    {
        return True;
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
    public function update(User $user, BackupRisk $backupError): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BackupRisk $backupError): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BackupRisk $backupError): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BackupRisk $backupError): bool
    {
        return false;
    }
}
