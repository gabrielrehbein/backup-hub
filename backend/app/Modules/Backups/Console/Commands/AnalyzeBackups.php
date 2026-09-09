<?php

namespace App\Modules\Backups\Console\Commands;

use App\Modules\Backups\Actions\VerifyBackupTimeAction;
use App\Modules\Backups\Contracts\Repositories\BackupRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AnalyzeBackups extends Command
{
    public function __construct(
        private readonly VerifyBackupTimeAction $verifyBackupTimeAction,
        private readonly BackupRepositoryInterface $backupRepository,
    ) {
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

    private function logMonitoring(string $message, array $context = [], string $status = 'error'): void
    {
        if($status === 'error') {
            Log::channel('backup_monitoring')->error($message, $context);
            return;
        }
        elseif($status === 'warning') {
            Log::channel('backup_monitoring')->warning($message, $context);
            return;
        }
        Log::channel('backup_monitoring')->info($message, $context);
    }

    public function handle()
    {
        $this->info('Analisando backups...');
        try {

            $lastBackupByInstance = $this->backupRepository->listLastBackupsGroupedBySystemInstance();
            foreach ($lastBackupByInstance as $backup) {
                if($backup->risks->where('type', 'time')->first()) {
                    $this->alert("Backup ID: {$backup->id} já possui risco de tempo associado. Pulando análise.");
                    $this->logMonitoring(
                        'Backup já possui risco de tempo associado. Pulando análise.',
                        ['backup_id' => $backup->id],
                        'warning'
                    );
                    continue;
                }
                $result = $this->verifyBackupTimeAction->execute($backup);
                if (!$result) {
                    $this->error("Risco de tempo identificado no backup ID: {$backup->id}");
                    $this->logMonitoring(
                        'Risco de tempo identificado no backup.',
                        ['backup_id' => $backup->id],
                        'error'
                    );
                } else {
                    $this->info("Backup ID: {$backup->id} está dentro do limite de tempo.");
                    $this->logMonitoring(
                        'Backup está dentro do limite de tempo.',
                        ['backup_id' => $backup->id],
                        'info'
                    );
                }
            }
            $this->info('Análise de backups concluída.');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Erro ao analisar backups: '.$e->getMessage());

            return Command::FAILURE;
        }
    }
}
