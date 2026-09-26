<?php

namespace App\Modules\Backups\Actions;

use App\Modules\Backups\Contracts\Repositories\BackupRepositoryInterface;
use App\Modules\Backups\Contracts\Services\BackupRiskServiceInterface;
use App\Modules\Backups\DTOs\CreateBackupRiskDTO;
use App\Modules\Backups\Models\Backup;
use App\Modules\Backups\Models\BackupRisk;
use App\Modules\Risks\Enums\RiskTypeEnum;
use App\Modules\Systems\Contracts\Repositories\SystemInstanceRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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

    public function execute(Backup $backup): ?BackupRisk
    {
        // Calcula o tempo em minutos perdido desde o último backup para o mesmo sistema
        $timeDifferenceInMinutes = $this->calculateTimeDifferenceInMinutes($backup);

        $risks = $this->systemInstanceRepository
            ->findById($backup->system_instance_id)
            ->client
            ->plan
            ->risks()
            ->orderBy('max_delay_limit_in_minutes')
            ->get();

        $biggestRiskDTO = null;

        foreach ($risks as $risk) {
            $excedeuLimite = $timeDifferenceInMinutes > $risk->max_delay_limit_in_minutes;
            $excedeuMensagem = $excedeuLimite ? "SIM" : "NÃO";

            Log::channel('daily')->info(
                "Diferença em minutos do backup ($timeDifferenceInMinutes) é maior que o limite máximo ($risk->max_delay_limit_in_minutes) do risco {$risk->name} = {$excedeuMensagem}"
            );

            if (!$excedeuLimite) {
                continue;
            }

            $biggestRiskDTO = new CreateBackupRiskDTO(
                backupId: $backup->id,
                riskId: $risk->id,
                type: RiskTypeEnum::TIME,
                isActive: true,
                delayInMinutes: $timeDifferenceInMinutes,
                sizeLossPercent: 0,
                description: $this->buildRiskMessage($backup, RiskTypeEnum::TIME, $timeDifferenceInMinutes),
            );
        }

        if (!$biggestRiskDTO) {
            return null;
        }

        $hasActiveTimeRisk = $backup->risks
            ->where('type', RiskTypeEnum::TIME->value)
            ->where("is_active", true)
            ->isNotEmpty();

        if ($hasActiveTimeRisk) {
            return $this->backupRiskService->replaceToBiggestRisk($biggestRiskDTO);
        }

        return $this->backupRiskService->create($biggestRiskDTO);
    }
}
