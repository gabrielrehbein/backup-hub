<?php

namespace App\Modules\Backups\Repositories;

use App\Modules\Backups\Contracts\Repositories\BackupRepositoryInterface;
use App\Modules\Backups\DTOs\BackupFilterDTO;
use App\Modules\Backups\DTOs\CreateBackupDTO;
use App\Modules\Backups\DTOs\UpdateBackupDTO;
use App\Modules\Backups\Models\Backup;


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
}
