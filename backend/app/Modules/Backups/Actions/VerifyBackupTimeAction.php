<?php

namespace App\Modules\Backups\Actions;

use App\Modules\Backups\Contracts\Repositories\BackupRepositoryInterface;
use App\Modules\Backups\Contracts\Services\BackupRiskServiceInterface;
use App\Modules\Backups\DTOs\CreateBackupRiskDTO;
use App\Modules\Backups\Models\Backup;
use App\Modules\Risks\Enums\RiskTypeEnum;
use App\Modules\Systems\Contracts\Repositories\SystemInstanceRepositoryInterface;
use Carbon\Carbon;


class VerifyBackupTimeAction
{
    public function __construct(
        private readonly BackupRepositoryInterface $backupRepository,
        private readonly BackupRiskServiceInterface $backupRiskService,
        private readonly SystemInstanceRepositoryInterface $systemInstanceRepository,
    ){}

    private function buildRiskMessage(Backup $backup, RiskTypeEnum $riskType, mixed $valueCause): string
    {
        return match ($riskType) {
            RiskTypeEnum::SIZE => "Risco por conta de perda de tamanho do backup. Backup gerado com tamanho de {$backup->file_size_kb} KB, que é menor que o último backup válido de {$valueCause} KB.",
            RiskTypeEnum::TIME => "Risco por conta de atraso na geração do backup. Backup gerado em {$backup->generated_at}, está {$valueCause} tempo sem ser gerado.",
        };
    }

    private function calculateTimeDifferenceInMinutes(Backup $backup): float
    {
        return (float) $backup->generated_at->diffInMinutes(Carbon::now());
    }

    public function execute(Backup $backup): bool
    {

        // Calcula o tempo em minutos perdido desde o último backup para o mesmo sistema
        $timeDifferenceInMinutes = $this->calculateTimeDifferenceInMinutes($backup);


        $risks = $this->systemInstanceRepository
            ->findById($backup->system_instance_id)
            ->client
            ->plan
            ->risks()
            ->orderByDesc('level')
            ->get();

        // Avalia os riscos de tempo do backup e cria um novo risco se necessário
        foreach ($risks as $risk) {
            if($timeDifferenceInMinutes > $risk->max_delay_limit_in_minutes){
                $createBackupRiskDTO = new CreateBackupRiskDTO(
                    backupId: $backup->id,
                    riskId: $risk->id,
                    type: RiskTypeEnum::TIME,
                    isActive: true,
                    delayInMinutes: $timeDifferenceInMinutes,
                    sizeLossPercent: 0,
                    description: $this->buildRiskMessage($backup, RiskTypeEnum::TIME, $timeDifferenceInMinutes)
                );
                $this->backupRiskService->create($createBackupRiskDTO);
                return false;
            }
        }

        return true;
    }
}
