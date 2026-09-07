<?php

namespace App\Modules\Backups\Console\Commands;

use App\Modules\Backups\Actions\VerifyBackupTimeAction;
use App\Modules\Backups\Contracts\Repositories\BackupRepositoryInterface;
use Illuminate\Console\Command;
use Override;

class AnalyzeBackups extends Command
{
    public function __construct(
        private readonly VerifyBackupTimeAction $verifyBackupTimeAction,
        private readonly BackupRepositoryInterface $backupRepository,
    )
    {
        return parent::__construct();
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:analyze';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Análisa o tempo do último backup de cada instancia';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Analisando backups...');

        $lastBackupByInstance = $this->backupRepository->listLastBackupsGroupedBySystemInstance();
        foreach ($lastBackupByInstance as $backup) {
            $result =$this->verifyBackupTimeAction->execute($backup);
            if(!$result){
                $this->error("Risco de tempo identificado no backup ID: {$backup->id}");
            }
            else {
                $this->info("Backup ID: {$backup->id} está dentro do limite de tempo.");
            }
            
        }
        $this->info('Análise de backups concluída.');
        return Command::SUCCESS;
    }
}
