<?php

namespace App\Modules\Backups\Contracts\Repositories;
use App\Modules\Backups\DTOs\FilterBackupRiskDTO;
use App\Modules\Backups\DTOs\CreateBackupRiskDTO;
use App\Modules\Backups\DTOs\UpdateBackupRiskDTO;
use App\Modules\Backups\Models\BackupRisk;


interface BackupRiskRepositoryInterface
{
    public function list(FilterBackupRiskDTO $filters): iterable;
    public function create(CreateBackupRiskDTO $payload): BackupRisk;
    public function findById(int $id): BackupRisk;
    public function update(UpdateBackupRiskDTO $payload, BackupRisk $backupRisk): BackupRisk;
    public function getTotalBackupRisks(?int $backupId = null, ?int $riskTypeId = null): int;
}
