<?php

namespace App\Modules\Backups\Contracts\Services;

use App\Modules\Backups\DTOs\BackupFilterDTO;
use App\Modules\Backups\DTOs\CreateBackupDTO;
use App\Modules\Backups\DTOs\UpdateBackupDTO;
use App\Modules\Backups\Models\Backup;
use App\Modules\Backups\DTOs\CreateBackupRequestDTO;


interface BackupServiceInterface
{
    public function list(BackupFilterDTO $filters): iterable;
    public function create(CreateBackupRequestDTO $payload): Backup;
    public function findById(int $id): ?Backup;
    public function update(UpdateBackupDTO $payload, int $id): Backup;
    public function getTotalBackups(): int;
    public function findBackupsGeneratedToday(): iterable;
    public function getTotalBackupsGeneratedToday(): int;
    public function findLastBackups(int $limit, ?bool $isLocal): iterable;
    public function findLastBackupByInstances(BackupFilterDTO $filters);
}
