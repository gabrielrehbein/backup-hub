<?php

namespace App\Modules\Backups\Contracts\Services;


use App\Modules\Backups\DTOs\FilterBackupRiskDTO;
use App\Modules\Backups\DTOs\CreateBackupRiskDTO;
use App\Modules\Backups\DTOs\UpdateBackupRiskDTO;
use App\Modules\Backups\Models\BackupRisk;


interface BackupRiskServiceInterface
{
    public function list(FilterBackupRiskDTO $filters): iterable;
    public function create(CreateBackupRiskDTO $payload): BackupRisk;
    public function findById(int $id): BackupRisk;
    public function update(UpdateBackupRiskDTO $payload, int $id): BackupRisk;
    public function toggleIsActive(int $id): BackupRisk;
    public function getTotalBackupRisks(?int $backupId = null, ?int $riskTypeId = null): int;
    public function getTotalBackupRisksByType(?int $backupId = null): array;
    public function getTotalRisk(?string $name = null);
}
