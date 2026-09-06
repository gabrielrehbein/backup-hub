<?php

namespace App\Modules\Backups\Services;

use App\Modules\Backups\Actions\SizeConveterAction;
use App\Modules\Backups\Actions\VerifyBackupSizeAction;
use App\Modules\Backups\Errors\BackupInFutureHttpException;
use App\Modules\Backups\Contracts\Repositories\BackupRepositoryInterface;
use App\Modules\Backups\Contracts\Services\BackupServiceInterface;
use App\Modules\Backups\DTOs\BackupFilterDTO;
use App\Modules\Backups\DTOs\CreateBackupDTO;
use App\Modules\Backups\DTOs\UpdateBackupDTO;
use App\Modules\Backups\Models\Backup;
use App\Modules\Backups\DTOs\CreateBackupRequestDTO;
use App\Modules\Backups\Repositories\BackupRiskEloquentRepository;
use App\Modules\Notifications\Services\SendNotificationService;
use App\Modules\Risks\Enums\RiskTypeEnum;
use App\Modules\Systems\Repositories\SystemInstanceEloquentRepository;

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
        
        if($payload->generatedAt > now()) {
            throw new BackupInFutureHttpException();
        }
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
        $backup = $this->backupRepository->create($BackupDTOWithConvertedSize);
        $verifyBackupSizeAction = new VerifyBackupSizeAction(
            $this->backupRepository,
            new BackupRiskService(
                new BackupRiskEloquentRepository(),
                $this->backupRepository,
                new SendNotificationService()
            ),
            new SystemInstanceEloquentRepository(),
        );
        $verifyBackupSizeAction->execute($backup);

        $backupWithTimeRisk = $this->backupRepository->findLastBackupWithRiskByRiskType(
            $backup->system_instance_id,
            RiskTypeEnum::TIME,
        );

        if($backupWithTimeRisk) {
            $this->backupRepository->deactivateRisk(
                $backupWithTimeRisk->id,
                RiskTypeEnum::TIME
            );
        }

        return $backup;
    }

    public function findById(int $id): Backup
    {
        return $this->backupRepository->findById($id);
    }

    public function update(UpdateBackupDTO $payload, int $id): Backup
    {
        if($payload->generatedAt > now()) {
            throw new BackupInFutureHttpException();
        }
        $backup = $this->backupRepository->findById($id);

        return $this->backupRepository->update($payload, $backup);
    }

    public function getTotalBackups(): int
    {
        return $this->backupRepository->getTotalBackups();
    }

    public function findBackupsGeneratedToday(): iterable
    {
        return $this->backupRepository->findBackupsGeneratedToday();
    }

    public function getTotalBackupsGeneratedToday(): int
    {
        $result = $this->backupRepository->getTotalBackupsGeneratedToday();
        return $result;
    }

    public function findLastBackups(int $limit, ?bool $isLocal): iterable
    {
        return $this->backupRepository->findLastBackups($limit, $isLocal);
    }
}
