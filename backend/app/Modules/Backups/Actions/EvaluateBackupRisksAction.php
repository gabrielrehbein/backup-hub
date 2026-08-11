<?php

namespace App\Modules\Backups\Actions;

use App\Modules\Backups\Contracts\Repositories\BackupRepositoryInterface;
use App\Modules\Backups\DTOs\CreateBackupDTO;
use App\Modules\Backups\Models\Backup;
use App\Modules\Risks\Enums\RiskTypeEnum;

class EvaluateBackupRisksAction
{
    public function __construct(
        private readonly BackupRepositoryInterface $backupRepository
    ){}


    public function execute(CreateBackupDTO $payload): array
    {
        $risks = [];

        $lastSizeValidBackup = $this->backupRepository->findLastBackupWithoutRiskByRiskType(
            $payload->systemInstanceId,
            RiskTypeEnum::SIZE
        );

        $lastBackupWithTimeRisk = $this->backupRepository->findLastBackupWithRiskByRiskType(
            $payload->systemInstanceId, 
            RiskTypeEnum::TIME
         );

        if($lastBackupWithTimeRisk){
            $this->backupRepository->deactivateRisk($lastBackupWithTimeRisk->id, RiskTypeEnum::TIME);
        }

        //VERIFICAR

    
        return $risks;
    }
}