<?php

namespace App\Modules\Backups\Http\Controllers;

use App\Modules\Backups\Contracts\Services\BackupServiceInterface;
use App\Modules\Backups\Http\Requests\StoreBackupRequest;
use App\Shared\Http\Controllers\Controller;
use App\Shared\Http\Responses\JSONResponse;
use App\Shared\Utils\BuildResponseMessage;
use App\Shared\Utils\ResourceEnum;
use App\Modules\Backups\Http\Requests\FilterBackupRequest;

class BackupController extends Controller
{
    public function __construct(
        private readonly BackupServiceInterface $backupService
    ) {}

    public function index(FilterBackupRequest $request)
    {
        $filters = $request->toDTO();
        $backups = $this->backupService->list($filters);

        return JSONResponse::success(
            $backups,
            BuildResponseMessage::findAll(ResourceEnum::BACKUP),
            200
        );
    }


    public function store(StoreBackupRequest $request)
    {
        $backup = $this->backupService->create($request->toDTO());
        return JSONResponse::success(
            $backup,
            BuildResponseMessage::create(ResourceEnum::BACKUP),
            201
        );
    }

    public function show(int $id)
    {
        $backup = $this->backupService->findById($id);
        return JSONResponse::success(
            $backup,
            BuildResponseMessage::findOne(ResourceEnum::BACKUP),
            200
        );
    }

}
