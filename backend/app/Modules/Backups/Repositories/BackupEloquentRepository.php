<?php

namespace App\Modules\Backups\Repositories;

use App\Modules\Backups\Contracts\Repositories\BackupRepositoryInterface;
use App\Modules\Backups\DTOs\BackupFilterDTO;
use App\Modules\Backups\DTOs\CreateBackupDTO;
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
    public function listLastBackupsGroupedBySystemInstance(BackupFilterDTO $filters): iterable
    {
        $results = DB::select(
            "SELECT DISTINCT ON (system_instance_id) *
             FROM backups
             ORDER BY system_instance_id, generated_at DESC"
        );

        // Converte o array de stdClass em uma coleção de modelos Backup
        return Backup::hydrate($results)->load('instances.client', 'instances.system')
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
        });
    }

}
