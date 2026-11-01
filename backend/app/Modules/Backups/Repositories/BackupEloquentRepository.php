<?php

namespace App\Modules\Backups\Repositories;

use App\Modules\Backups\Contracts\Repositories\BackupRepositoryInterface;
use App\Modules\Backups\DTOs\BackupFilterDTO;
use App\Modules\Backups\DTOs\CreateBackupDTO;
use App\Modules\Backups\DTOs\FilterLastBackupByIntenceDTO;
use App\Modules\Backups\DTOs\UpdateBackupDTO;
use App\Modules\Backups\Models\Backup;
use App\Modules\Risks\Enums\RiskTypeEnum;
use Illuminate\Support\Facades\DB;

class BackupEloquentRepository implements BackupRepositoryInterface
{
    private const DEFAULT_QUANTITY_BY_PAGE = 20;

    public function list(BackupFilterDTO $filters): iterable
    {
        $perPage = $filters->perPage ?? self::DEFAULT_QUANTITY_BY_PAGE;

        return Backup::query()
            ->when($filters->startGeneratedAt, function ($query) use ($filters) {
                $query->where('generated_at', '>=', $filters->startGeneratedAt);
            })
            ->when($filters->endGeneratedAt, function ($query) use ($filters) {
                $query->where('generated_at', '<=', $filters->endGeneratedAt);
            })
            ->when($filters->isLocal !== null, function ($query) use ($filters) {
                $query->where('is_local', $filters->isLocal);
            })
            ->when($filters->minSize !== null, function ($query) use ($filters) {
                $query->where('file_size_kb', '>=', $filters->minSize);
            })
            ->when($filters->maxSize !== null, function ($query) use ($filters) {
                $query->where('file_size_kb', '<=', $filters->maxSize);
            })
            ->when($filters->systemInstanceId !== null, function ($query) use ($filters) {
                $query->where('system_instance_id', $filters->systemInstanceId);
            })
            ->paginate($perPage);
    }

    public function create(CreateBackupDTO $payload): Backup
    {
        return Backup::create($payload->toArray());
    }

    public function findById(int $id): Backup
    {
        return Backup::findOrFail($id);
    }

    public function update(UpdateBackupDTO $payload, Backup $backup): Backup
    {
        $backup = $backup->fill($payload->toArray());
        if ($backup->isDirty()) {
            $backup->save();
        }

        return $backup;
    }

    public function findLastBackupWithoutAnyRisk(int $systemInstanceId): ?Backup
    {
        return Backup::query()
            ->where('backups.system_instance_id', $systemInstanceId)
            ->whereNotExists(
                function ($query) {
                    $query->selectRaw(1)
                        ->from('backup_risks')
                        ->whereColumn('backup_risks.backup_id', 'backups.id')
                        ->where('backup_risks.is_active', true);
                }
            )
            ->select('backups.*')
            ->orderByDesc('backups.generated_at')
            ->first();
    }

    public function findLastBackupWithRiskByRiskType(int $systemInstanceId, RiskTypeEnum $riskType): ?Backup
    {
        return Backup::query()
            ->where('backups.system_instance_id', $systemInstanceId)
            ->whereExists(
                function ($query) use ($riskType) {
                    $query->selectRaw(1)
                        ->from('backup_risks')
                        ->whereColumn('backup_risks.backup_id', 'backups.id')
                        ->where('backup_risks.type', $riskType)
                        ->where('backup_risks.is_active', true);
                }
            )
            ->select('backups.*')
            ->orderByDesc('backups.generated_at')
            ->first();
    }

    public function findLastBackupWithoutRiskByRiskType(
        int $systemInstanceId,
        RiskTypeEnum $riskType,
        ?int $excludeBackupId = null
    ): ?Backup {
        return Backup::query()
            ->where('backups.system_instance_id', $systemInstanceId)
            ->when(
                $excludeBackupId !== null,
                fn ($query) => $query->where('backups.id', '<>', $excludeBackupId)
            )
            ->whereNotExists(function ($query) use ($riskType) {
                $query->selectRaw(1)
                    ->from('backup_risks')
                    ->whereColumn('backup_risks.backup_id', 'backups.id')
                    ->where('backup_risks.type', $riskType->value)
                    ->where('backup_risks.is_active', true);
            })
            ->select('backups.*')
            ->orderByDesc('backups.generated_at')
            ->first();
    }

    public function deactivateRisk(int $backupId, RiskTypeEnum $riskType): int
    {
        $backup = $this->findById($backupId);

        return $backup
            ->risks()
            ->where('type', $riskType->value)
            ->update(
                ['is_active' => false]
            );
    }

    public function getTotalBackups(): int
    {
        return Backup::count();
    }

    public function findBackupsGeneratedToday(): iterable
    {
        return Backup::query()
            ->whereDate('generated_at', now()->toDateString())
            ->get();
    }

    public function getTotalBackupsGeneratedToday(): int
    {
        return Backup::query()
            ->whereDate('generated_at', today()->toDateString())
            ->count();
    }

    public function findLastBackups(int $limit, ?bool $isLocal = null, ?int $excludeBackupId = null, ?int $systemInstanceId = null): iterable
    {
        $result = Backup::with('instances.client')
            ->when($isLocal !== null, function ($query) use ($isLocal) {
                $query->where('is_local', $isLocal);
            })
            ->when($excludeBackupId !== null, function ($query) use ($excludeBackupId) {
                $query->where('backups.id', '<>', $excludeBackupId);
            })
            ->when($systemInstanceId !== null, function ($query) use ($systemInstanceId) {
                $query->where('backups.system_instance_id', $systemInstanceId);
            })
            ->orderByDesc('generated_at')
            ->limit($limit)
            ->get();

        return $result;
    }

    public function findLastBackupsByClient(): iterable
    {
        return [];
    }

    public function existsByRiskType(?int $backupId, RiskTypeEnum $riskType, bool $onlyActive = true): bool
    {
        return Backup::query()
            ->when($backupId !== null, function ($query) use ($backupId) {
                $query->where('backups.id', $backupId);
            })
            ->whereHas('risks', function ($query) use ($riskType, $onlyActive) {
                $query->where('type', $riskType->value);
                if ($onlyActive) {
                    $query->where('is_active', true);
                }
            })
            ->exists();
    }
    public function listLastBackupsGroupedBySystemInstance(?FilterLastBackupByIntenceDTO $filters = null): iterable
    {
        // IDs do último backup de cada instância (PostgreSQL DISTINCT ON).
        // Os filtros são aplicados depois, para que o resultado continue sendo
        // "o último backup da instância" e não "o último backup que bate com o filtro".
        $latestBackupIds = DB::table('backups')
            ->selectRaw('DISTINCT ON (system_instance_id) id')
            ->orderBy('system_instance_id')
            ->orderByDesc('generated_at')
            ->orderByDesc('id');

        return Backup::query()
            ->whereIn('id', $latestBackupIds)
            ->with(['instances.client', 'instances.system'])
            ->when($filters?->minSize !== null, fn ($query) =>
                $query->where('file_size_kb', '>=', $filters->minSize)
            )
            ->when($filters?->maxSize !== null, fn ($query) =>
                $query->where('file_size_kb', '<=', $filters->maxSize)
            )
            ->when($filters?->generatedAtStart !== null, fn ($query) =>
                $query->where('generated_at', '>=', $filters->generatedAtStart)
            )
            ->when($filters?->generatedAtEnd !== null, fn ($query) =>
                $query->where('generated_at', '<=', $filters->generatedAtEnd)
            )
            ->when($filters?->clientId !== null, fn ($query) =>
                $query->whereHas('instances', fn ($instance) =>
                    $instance->where('client_id', $filters->clientId)
                )
            )
            ->when($filters?->planId !== null, fn ($query) =>
                $query->whereHas('instances.client', fn ($client) =>
                    $client->where('plan_id', $filters->planId)
                )
            )
            ->when($filters?->version !== null, fn ($query) =>
                $query->where('version', "LIKE", "%$filters->version%")
            )
            ->when($filters?->riskName !== null || $filters?->riskType !== null, fn ($query) =>
                $query->whereHas('risks', function ($backupRisk) use ($filters) {
                    $backupRisk->where('is_active', true)
                        ->when($filters->riskType !== null, fn ($q) =>
                            $q->where('type', $filters->riskType->value)
                        )
                        ->when($filters->riskName !== null, fn ($q) =>
                            $q->whereHas('risk', fn ($risk) =>
                                $risk->whereRaw('LOWER(name) = ?', [mb_strtolower($filters->riskName)])
                            )
                        );
                })
            )
            ->orderByDesc('generated_at')
            ->get();
    }

}
