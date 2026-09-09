<?php

namespace App\Modules\Backups\Actions;

use App\Modules\Backups\Contracts\Repositories\BackupRepositoryInterface;
use App\Modules\Backups\Contracts\Services\BackupRiskServiceInterface;
use App\Modules\Backups\DTOs\CreateBackupRiskDTO;
use App\Modules\Backups\Models\Backup;
use App\Modules\Risks\Enums\RiskTypeEnum;
use App\Modules\Systems\Contracts\Repositories\SystemInstanceRepositoryInterface;


class VerifyBackupSizeAction
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

    private function calculateSizeLossPercentage(Backup $currentBackup, ?Backup $lastSizeValidBackup): float
    {
        if(!$lastSizeValidBackup){
            return 0;
        }
        if( $currentBackup->file_size_kb >= $lastSizeValidBackup->file_size_kb){
            return 0;
        }
        if ($currentBackup->file_size_kb === 0 || $lastSizeValidBackup->file_size_kb === 0) {
            return 0;
        }

        $sizeDifference = $lastSizeValidBackup->file_size_kb - $currentBackup->file_size_kb;

        return ($sizeDifference / $lastSizeValidBackup->file_size_kb) * 100;
    }

    public function execute(Backup $backup)
    {

        // Pega último backup válido sem risco de tamanho para o mesmo sistema
        $lastSizeValidBackup = $this->backupRepository->findLastBackupWithoutRiskByRiskType(
            $backup->system_instance_id,
            RiskTypeEnum::SIZE,
            $backup->id
        );

        if($lastSizeValidBackup === null){
            return;
        }

        // Calcula o tamanho perdido desde o último backup válido para o mesmo sistema
        $sizeLossPercentage = $this->calculateSizeLossPercentage($backup, $lastSizeValidBackup);

        if($sizeLossPercentage === 0){
            return;
        }

        $risks = $this->systemInstanceRepository
            ->findById($backup->system_instance_id)
            ->client
            ->plan
            ->risks()
            ->orderByDesc('level')
            ->get();

        // Avalia os riscos de tamanho do backup e cria um novo risco se necessário
        foreach ($risks as $risk) {
            if($sizeLossPercentage > $risk->max_size_loss_in_percent){
                $createBackupRiskDTO = new CreateBackupRiskDTO(
                    backupId: $backup->id,
                    riskId: $risk->id,
                    type: RiskTypeEnum::SIZE,
                    isActive: true,
                    delayInMinutes: 0,
                    sizeLossPercent: $sizeLossPercentage,
                    description: $this->buildRiskMessage($backup, RiskTypeEnum::SIZE, $lastSizeValidBackup->file_size_kb)
                );
                $this->backupRiskService->create($createBackupRiskDTO);

                break;
            }
        }

    }
}
