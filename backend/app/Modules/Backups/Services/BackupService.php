<?php

namespace App\Modules\Backups\Services;

use App\Modules\Backups\Actions\SizeConveterAction;
use App\Modules\Backups\Actions\VerifyBackupSizeAction;
use App\Modules\Backups\Errors\BackupInFutureHttpException;
use App\Modules\Backups\Contracts\Repositories\BackupRepositoryInterface;
use App\Modules\Backups\Contracts\Repositories\BackupRiskRepositoryInterface;
use App\Modules\Backups\Contracts\Services\BackupServiceInterface;
use App\Modules\Backups\DTOs\BackupFilterDTO;
use App\Modules\Backups\DTOs\CreateBackupDTO;
use App\Modules\Backups\DTOs\UpdateBackupDTO;
use App\Modules\Backups\Errors\BackupSaveHttpException;
use App\Modules\Backups\Models\Backup;
use App\Modules\Backups\DTOs\CreateBackupRequestDTO;
use App\Modules\Backups\DTOs\FilterLastBackupByIntenceDTO;
use App\Modules\Backups\Repositories\BackupRiskEloquentRepository;
use App\Modules\Notifications\Services\SendNotificationService;
use App\Modules\Risks\Enums\RiskTypeEnum;
use App\Modules\Systems\Repositories\SystemInstanceEloquentRepository;
use Illuminate\Support\Facades\DB;

class BackupService implements BackupServiceInterface
{
    public function __construct(
        private readonly BackupRepositoryInterface $backupRepository,
        private readonly BackupRiskRepositoryInterface $backupRiskRepository,
    ) {}

    public function list(BackupFilterDTO $filters): iterable
    {
        $backups = $this->backupRepository->list($filters);
        return $backups;
    }

    public function create(CreateBackupRequestDTO $payload): Backup
    {
        return DB::transaction(function () use ($payload) {
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
            $sizeRisk = $verifyBackupSizeAction->execute($backup);
            if (!$sizeRisk) {
                $this->backupRiskRepository->deactivatePreviousRisksByInstance(
                    $backup->system_instance_id,
                    RiskTypeEnum::SIZE,
                    $backup->id,
                );
            }

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


            return $backup->load('risks');
        });
    }

    public function findById(int $id): Backup
    {
        return $this->backupRepository->findById($id);
    }

    public function update(UpdateBackupDTO $payload, int $id): Backup
    {
        return DB::transaction(function () use ($payload, $id) {
            if($payload->generatedAt > now()) {
                throw new BackupInFutureHttpException();
            }
            $backup = $this->backupRepository->findById($id);

            $backupUpdated = $this->backupRepository->update($payload, $backup);

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

            return $backupUpdated;
        });
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

    public function findLastBackupByInstances(FilterLastBackupByIntenceDTO $filters)
    {
        return $this->backupRepository->listLastBackupsGroupedBySystemInstance($filters);
    }

    public function countBackupWithoutRisk(): int
    {
        return Backup::whereDoesntHave('risks', fn ($q) => $q->where('is_active', true))->count();
    }

    public function getGeneratedTodayByHour(){
        return $this->backupRepository->getGeneratedTodayByHour();
    }

    public function getTotalBackupsWithRisk(): int {
        return $this->backupRepository->getTotalBackupsWithRisk();
    }

    public function findByIdWithRelations(int $id): ?Backup
    {
        return Backup::with([
            'instances.client',
            'instances.system',
        ])->orderByDesc("generated_at")->find($id);
    }
    public function findByInstanceId(int $id) {
        return Backup::with([
            'instances.client',
            'instances.system',
        ])->where("system_instance_id", $id)->get();
    }
}
