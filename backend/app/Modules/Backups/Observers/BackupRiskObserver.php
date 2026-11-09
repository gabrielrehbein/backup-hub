<?php

namespace App\Modules\Backups\Observers;

use App\Modules\Backups\Models\BackupRisk;
use App\Modules\Backups\Services\BackupRiskService;

class BackupRiskObserver
{
    public function __construct(
        private BackupRiskService $backupRiskService
    ){}

    public function created(BackupRisk $backupRisk): void
    {
        $nofied = $this->backupRiskService->notifyIfNeeded($backupRisk);
        if ($nofied) {
            
        }
    }

    public function updated(BackupRisk $backupRisk): void
    {
        if ($backupRisk->wasChanged('is_active')) {
            $this->backupRiskService->notifyIfNeeded($backupRisk);
        }
    }
}
