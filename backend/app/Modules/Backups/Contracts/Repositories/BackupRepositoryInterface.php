<?php

namespace App\Modules\Backups\Contracts\Repositories;

use App\Modules\Backups\DTOs\BackupFilterDTO;
use App\Modules\Backups\DTOs\CreateBackupDTO;
use App\Modules\Backups\DTOs\UpdateBackupDTO;
use App\Modules\Backups\Models\Backup;
use App\Modules\Risks\Enums\RiskTypeEnum;

interface BackupRepositoryInterface
{
    public function list(BackupFilterDTO $filters): iterable;
    public function create(CreateBackupDTO $payload): Backup;
    public function findById(int $id): Backup;
    public function update(UpdateBackupDTO $payload, Backup $backup): Backup;
    public function findLastBackupWithoutRiskByRiskType(int $systemInstanceId, RiskTypeEnum $riskType, ?int $excludeBackupId): ?Backup;
    public function findLastBackupWithoutAnyRisk(int $systemInstanceId): ?Backup;
    public function findLastBackupWithRiskByRiskType(int $systemInstanceId, RiskTypeEnum $riskType): ?Backup;
    public function deactivateRisk(int $backupId, RiskTypeEnum $riskType): int;
    public function getTotalBackups(): int;
    public function findBackupsGeneratedToday(): iterable;
    public function getTotalBackupsGeneratedToday(): int;
    public function findLastBackups(int $limit, ?bool $isLocal): iterable;
    public function findLastBackupsByClient(): iterable;
}
