<?php

namespace App\Modules\Backups\Services;

use App\Modules\Backups\Actions\SizeConveterAction;
use App\Modules\Backups\Contracts\Repositories\BackupRepositoryInterface;
use App\Modules\Backups\Contracts\Services\BackupServiceInterface;
use App\Modules\Backups\DTOs\BackupFilterDTO;
use App\Modules\Backups\DTOs\CreateBackupDTO;
use App\Modules\Backups\DTOs\UpdateBackupDTO;
use App\Modules\Backups\Models\Backup;
use App\Modules\Backups\DTOs\CreateBackupRequestDTO;


class BackupService implements BackupServiceInterface
{
    public function __construct(
        private readonly BackupRepositoryInterface $backupRepository
    ) {}

    public function list(BackupFilterDTO $filters): iterable
    {
        $backups = $this->backupRepository->list($filters);
        return $backups;
    }

    public function create(CreateBackupRequestDTO $payload): Backup
    {
        $convertedFileSize = SizeConveterAction::toKb($payload->fileSize, $payload->sizeType);
        $BackupDTOWithConvertedSize = new CreateBackupDTO(
            fileSize: $convertedFileSize,
            generatedAt: $payload->generatedAt,
            isLocal: $payload->isLocal,
            systemInstanceId: $payload->systemInstanceId,
            sourceIp: $payload->sourceIp,
            filePath: $payload->filePath,
            version: $payload->version
        );
        return $this->backupRepository->create($BackupDTOWithConvertedSize);
    }

    public function findById(int $id): Backup
    {
        return $this->backupRepository->findById($id);
    }

    public function update(UpdateBackupDTO $payload, int $id): Backup
    {
        $backup = $this->backupRepository->findById($id);

        return $this->backupRepository->update($payload, $backup);
    }
}
