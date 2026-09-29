<?php

namespace App\Modules\Backups\Jobs;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class VerifyBackupTimeJob implements ShouldQueue
{
    use Queueable;
    
    public function __construct(
        private readonly int $backupId,
    ) {}

    public function handle(): void
    {
        // Aqui você pode chamar a ação de verificação de tempo do backup
        // Por exemplo:
        // $backup = Backup::find($this->backupId);
        // (new VerifyBackupTimeAction())->execute($backup);
    }
}
