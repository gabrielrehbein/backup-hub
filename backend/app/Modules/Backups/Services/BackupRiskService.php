<?php

namespace App\Modules\Backups\Services;

use App\Modules\Backups\Contracts\Repositories\BackupRiskRepositoryInterface;
use App\Modules\Backups\Contracts\Services\BackupRiskServiceInterface;
use App\Modules\Backups\DTOs\CreateBackupRiskDTO;
use App\Modules\Backups\DTOs\FilterBackupRiskDTO;
use App\Modules\Backups\DTOs\UpdateBackupRiskDTO;
use App\Modules\Backups\Models\BackupRisk;

class BackupRiskService implements BackupRiskServiceInterface
{
    public function __construct(
        private readonly BackupRiskRepositoryInterface $backupRiskRepository
    ) {}

    public function list(FilterBackupRiskDTO $filters): iterable
    {
        return $this->backupRiskRepository->list($filters);
    }

    public function create(CreateBackupRiskDTO $payload): BackupRisk
    {
        return $this->backupRiskRepository->create($payload);
    }

    public function findById(int $id): BackupRisk
    {
        return $this->backupRiskRepository->findById($id);
    }

    public function update(UpdateBackupRiskDTO $payload, int $id): BackupRisk
    {
        $backupRisk = $this->findById($id);

        return $this->backupRiskRepository->update($payload, $backupRisk);
    }

    public function toggleIsActive(int $id): BackupRisk
    {
        $backupRisk = $this->findById($id);
        $backupRisk->is_active = ! $backupRisk->is_active;
        $backupRisk->save();

        return $backupRisk;
    }

    public function getTotalBackupRisks(?int $backupId = null, ?int $riskTypeId = null): int
    {
        return $this->backupRiskRepository->getTotalBackupRisks($backupId, $riskTypeId);
    }
}