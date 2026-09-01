<?php

namespace App\Modules\Backups\Services;

use App\Modules\Backups\Contracts\Repositories\BackupRepositoryInterface;
use App\Modules\Backups\Contracts\Repositories\BackupRiskRepositoryInterface;
use App\Modules\Backups\Contracts\Services\BackupRiskServiceInterface;
use App\Modules\Backups\DTOs\CreateBackupRiskDTO;
use App\Modules\Backups\DTOs\FilterBackupRiskDTO;
use App\Modules\Backups\DTOs\UpdateBackupRiskDTO;
use App\Modules\Backups\Errors\RiskTypeIsUniqueByBackupHttpException;
use App\Modules\Backups\Models\BackupRisk;
use App\Modules\Notifications\Actions\NotifyBackupRiskByMail;
use App\Modules\Notifications\Contracts\Services\NotificationServiceInterface;
use App\Modules\Risks\Enums\RiskTypeEnum;


class BackupRiskService implements BackupRiskServiceInterface
{
    public function __construct(
        private readonly BackupRiskRepositoryInterface $backupRiskRepository,
        private readonly BackupRepositoryInterface $backupRepository,
        private readonly NotificationServiceInterface $notify,
    ) {}

    private function notifyIfNeeded(BackupRisk $backupRisk): void
    {
        if($backupRisk->risk->notifiable && $backupRisk->is_active){
            $this->notify->addNotificationMethod(
                new NotifyBackupRiskByMail(
                    $backupRisk,
                    "gabadev63@gmail.com"
                )
            );
            $this->notify->sendNotifications();
        }
    }

    private function backupWithRiskAlreadyExists(int $backupId, RiskTypeEnum $riskType): bool {
        return $this->backupRepository->existsByRiskType($backupId, $riskType);
    }

    public function list(FilterBackupRiskDTO $filters): iterable
    {
        return $this->backupRiskRepository->list($filters);
    }

    public function create(CreateBackupRiskDTO $payload): BackupRisk
    {
        if ($this->backupWithRiskAlreadyExists($payload->backupId, $payload->type)){
            throw new RiskTypeIsUniqueByBackupHttpException();
        }
        $backupRisk = $this->backupRiskRepository->create($payload);
        $this->notifyIfNeeded($backupRisk);
        return $backupRisk;
    }

    public function findById(int $id): BackupRisk
    {
        return $this->backupRiskRepository->findById($id);
    }

    public function update(UpdateBackupRiskDTO $payload, int $id): BackupRisk
    {
        $backupRisk = $this->findById($id);

        $updatedBackupRisk = $this->backupRiskRepository->update($payload, $backupRisk);
        $this->notifyIfNeeded($updatedBackupRisk);
        return $updatedBackupRisk;
    }

    public function toggleIsActive(int $id): BackupRisk
    {
        $backupRisk = $this->findById($id);
        $backupRisk->is_active = ! $backupRisk->is_active;
        $backupRisk->save();
        $this->notifyIfNeeded($backupRisk);

        return $backupRisk;
    }

    public function getTotalBackupRisks(?int $backupId = null, ?int $riskTypeId = null): int
    {
        return $this->backupRiskRepository->getTotalBackupRisks($backupId, $riskTypeId);
    }

    public function getTotalBackupRisksByType(?int $backupId = null): array
    {
        return $this->backupRiskRepository->getTotalBackupRisksByType($backupId);
    }
}