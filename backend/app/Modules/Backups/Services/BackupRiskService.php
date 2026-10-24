<?php

namespace App\Modules\Backups\Services;

use App\Modules\Backups\Contracts\Repositories\BackupRepositoryInterface;
use App\Modules\Backups\Contracts\Repositories\BackupRiskRepositoryInterface;
use App\Modules\Backups\Contracts\Services\BackupRiskServiceInterface;
use App\Modules\Backups\DTOs\CreateBackupRiskDTO;
use App\Modules\Backups\DTOs\FilterBackupRiskDTO;
use App\Modules\Backups\DTOs\UpdateBackupRiskDTO;
use App\Modules\Backups\Errors\RiskTypeIsUniqueByBackupHttpException;
use App\Modules\Backups\Models\Backup;
use App\Modules\Backups\Models\BackupRisk;
use App\Modules\Notifications\Actions\NotifyBackupRiskByMail;
use App\Modules\Notifications\Contracts\Services\NotificationServiceInterface;
use App\Modules\Notifications\Models\NotificationConfig;
use App\Modules\Risks\Enums\RiskTypeEnum;
use App\Modules\Risks\Models\Risk;
use Illuminate\Support\Facades\DB;
use Override;

class BackupRiskService implements BackupRiskServiceInterface
{
    public function __construct(
        private readonly BackupRiskRepositoryInterface $backupRiskRepository,
        private readonly BackupRepositoryInterface $backupRepository,
        private readonly NotificationServiceInterface $notify,
    ) {}

    public function findByBackupId(int $backupId): iterable
    {
        return $this->backupRiskRepository->findByBackupId($backupId);
    }

    public function notifyIfNeeded(BackupRisk $backupRisk): void
    {
        if(!$backupRisk->risk->notifiable || !$backupRisk->is_active){
            return;
        }

        $notifyTo = NotificationConfig::first()?->email;

        if(!$notifyTo){
            return;
        }

        $this->notify->addNotificationMethod(
            new NotifyBackupRiskByMail(
                $backupRisk,
                NotificationConfig::first()?->email ?? ''
            )
        );
        $this->notify->sendNotifications();
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
        return $backupRisk;
    }

    public function findById(int $id): BackupRisk
    {
        return $this->backupRiskRepository->findById($id);
    }


    public function replaceToBiggestRisk(CreateBackupRiskDTO $payload): BackupRisk
    {
        $backup = $this->backupRepository->findById($payload->backupId);
        $risk = Risk::findOrFail($payload->riskId);

        $currentTimeRisk = $backup->risks()
            ->where('type', '=', $payload->type)
            ->where('is_active', true)
            ->first();


        if ($currentTimeRisk && $currentTimeRisk->risk->level >= $risk->level) {
            return $currentTimeRisk;
        }

        $currentTimeRisk->is_active = false;
        $currentTimeRisk->save();
        return $this->create($payload);
    }

    public function update(UpdateBackupRiskDTO $payload, int $id): BackupRisk
    {
        $backupRisk = $this->findById($id);
        if ($payload->type !== $backupRisk->risk->type && $this->backupWithRiskAlreadyExists($payload->backupId, $payload->type)){
            throw new RiskTypeIsUniqueByBackupHttpException();
        }
        $updatedBackupRisk = $this->backupRiskRepository->update($payload, $backupRisk);
        return $updatedBackupRisk;
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

    public function getTotalBackupRisksByType(?int $backupId = null): array
    {
        return $this->backupRiskRepository->getTotalBackupRisksByType($backupId);
    }

    public function getTotalRisk(?string $name = null){
        if(!$name){
            return [
                'name' => 'Sem risco',
                'level' => 0,
                'quantity' => Backup::whereDoesntHave('risks', function ($query) {
                    $query->where('is_active', true);
                })
                ->count()
            ];
        }
        $risks = BackupRisk::query()
            ->join('risks', 'risks.id', '=', 'backup_risks.risk_id')
            ->select(
                'risks.name',
                'risks.level',
                DB::raw('COUNT(*) as quantity')
            )
            ->where('risks.name', $name)
            ->where('backup_risks.is_active', true)
            ->groupBy('risks.name', 'risks.level')
            ->get()
            ->keyBy('name');

        return [
            'name' => $name,
            'level' => $risks->get($name)?->level ?? 0,
            'quantity' => $risks->get($name)?->quantity ?? 0
        ];

    }
}
