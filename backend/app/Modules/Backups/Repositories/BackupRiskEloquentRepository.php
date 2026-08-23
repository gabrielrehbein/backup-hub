<?php

namespace App\Modules\Backups\Repositories;

use App\Modules\Backups\Contracts\Repositories\BackupRiskRepositoryInterface;
use App\Modules\Backups\DTOs\CreateBackupRiskDTO;
use App\Modules\Backups\DTOs\FilterBackupRiskDTO;
use App\Modules\Backups\DTOs\UpdateBackupRiskDTO;
use App\Modules\Backups\Models\BackupRisk;

class BackupRiskEloquentRepository implements BackupRiskRepositoryInterface
{
    private const DEFAULT_QUANTITY_BY_PAGE = 20;

    public function list(FilterBackupRiskDTO $filters): iterable
    {
        $perPage = self::DEFAULT_QUANTITY_BY_PAGE;

        return BackupRisk::query()
            ->when($filters->backupId !== null, function ($query) use ($filters) {
                $query->where('backup_id', $filters->backupId);
            })
            ->when($filters->riskId !== null, function ($query) use ($filters) {
                $query->where('risk_id', $filters->riskId);
            })
            ->when($filters->type !== null, function ($query) use ($filters) {
                $query->where('type', $filters->type->value);
            })
            ->when($filters->isActive !== null, function ($query) use ($filters) {
                $query->where('is_active', $filters->isActive);
            })
            ->when($filters->minDelayInMinutes !== null, function ($query) use ($filters) {
                $query->where('delay_in_minutes', '>=', $filters->minDelayInMinutes);
            })
            ->when($filters->maxDelayInMinutes !== null, function ($query) use ($filters) {
                $query->where('delay_in_minutes', '<=', $filters->maxDelayInMinutes);
            })
            ->when($filters->minSizeLossPercent !== null, function ($query) use ($filters) {
                $query->where('size_loss_percent', '>=', $filters->minSizeLossPercent);
            })
            ->when($filters->maxSizeLossPercent !== null, function ($query) use ($filters) {
                $query->where('size_loss_percent', '<=', $filters->maxSizeLossPercent);
            })
            ->paginate($perPage);
    }

    public function create(CreateBackupRiskDTO $payload): BackupRisk
    {
        return BackupRisk::create($payload->toArray());
    }

    public function findById(int $id): BackupRisk
    {
        return BackupRisk::findOrFail($id);
    }

    public function update(UpdateBackupRiskDTO $payload, BackupRisk $backupRisk): BackupRisk
    {
        $backupRisk = $backupRisk->fill($payload->toArray());

        if ($backupRisk->isDirty()) {
            $backupRisk->save();
        }

        return $backupRisk;
    }

    public function getTotalBackupRisks(?int $backupId = null, ?int $riskTypeId = null): int
    {
        return BackupRisk::query()
            ->when($backupId !== null, function ($query) use ($backupId) {
                $query->where('backup_id', $backupId);
            })
            ->when($riskTypeId !== null, function ($query) use ($riskTypeId) {
                $query->where('risk_id', $riskTypeId);
            })
            ->count();
    }
}
