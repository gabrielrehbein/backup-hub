<?php

namespace App\Modules\Backups\Contracts\Repositories;


use App\Modules\Backups\DTOs\FilterBackupRiskDTO;
use App\Modules\Backups\DTOs\CreateBackupRiskDTO;
use App\Modules\Backups\DTOs\UpdateBackupRiskDTO;
use App\Modules\Backups\Models\BackupRisk;
use App\Modules\Risks\Enums\RiskTypeEnum;

interface BackupRiskRepositoryInterface
{
    public function findByBackupId(int $backupId): iterable;
    public function list(FilterBackupRiskDTO $filters): iterable;
    public function create(CreateBackupRiskDTO $payload): BackupRisk;
    public function deactivatePreviousRisksByInstance(int $systemInstanceId, RiskTypeEnum $riskType, int $exceptBackupId): int;
    public function findById(int $id): BackupRisk;
    public function update(UpdateBackupRiskDTO $payload, BackupRisk $backupRisk): BackupRisk;
    public function getTotalBackupRisks(?int $backupId = null, ?int $riskTypeId = null): int;
    public function getTotalBackupRisksByType(?int $backupId = null): array;
    public function getClientsWithMostRisks(int $planId, int $limit = 5): iterable;
}
