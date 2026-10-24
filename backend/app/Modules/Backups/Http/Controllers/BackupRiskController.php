<?php

namespace App\Modules\Backups\Http\Controllers;

use App\Modules\Backups\Contracts\Services\BackupRiskServiceInterface;
use App\Modules\Backups\Http\Resources\BackupRiskByBackupResource;
use App\Shared\Http\Controllers\Controller;
use App\Shared\Http\Responses\JSONResponse;
use App\Shared\Utils\BuildResponseMessage;
use App\Shared\Utils\ResourceEnum;
use App\Modules\Backups\Http\Resources\LastBackupsResource;
use App\Modules\Backups\Services\BackupRiskService;


class BackupRiskController extends Controller
{
    public function __construct(
        private readonly BackupRiskServiceInterface $backupRiskService,
    ) {}
    public function findByBackupId(int $id){
        $backupRisks = $this->backupRiskService->findByBackupId($id);

        return JSONResponse::success(
            BackupRiskByBackupResource::collection($backupRisks),
            BuildResponseMessage::findAll(ResourceEnum::BACKUP_RISK),
            200
        );
    }

}
