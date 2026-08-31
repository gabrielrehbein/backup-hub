<?php

namespace App\Modules\Backups\Http\Controllers;

use App\Modules\Backups\Contracts\Services\BackupServiceInterface;
use App\Modules\Backups\DTOs\CreateBackupRiskDTO;
use App\Modules\Backups\Http\Requests\StoreBackupRequest;
use App\Shared\Http\Controllers\Controller;
use App\Shared\Http\Responses\JSONResponse;
use App\Shared\Utils\BuildResponseMessage;
use App\Shared\Utils\ResourceEnum;
use App\Modules\Backups\Http\Requests\FilterBackupRequest;
use App\Modules\Backups\Http\Resources\BackupResource;
use App\Modules\Backups\Repositories\BackupEloquentRepository;
use App\Modules\Backups\Repositories\BackupRiskEloquentRepository;
use App\Modules\Backups\Services\BackupRiskService;
use App\Modules\Notifications\Actions\NotifyBackupWithRisk;
use App\Modules\Risks\Enums\RiskTypeEnum;
use App\Modules\Systems\Models\SystemInstance;

class BackupController extends Controller
{
    public function __construct(
        private readonly BackupServiceInterface $backupService
    ) {}

    public function testRisk()
    {
        $backupRiskService = new BackupRiskService(
            new BackupRiskEloquentRepository(),
            new BackupEloquentRepository(),
            new NotifyBackupWithRisk(),
        );

        $br = $backupRiskService->create(
            new CreateBackupRiskDTO(
                2,
                3,
                RiskTypeEnum::TIME,
                true,
                0,
                13240,
                ""
            )
        );


        return JSONResponse::success(
            null,
            "teste",
            200
        );
    }

    public function index(FilterBackupRequest $request)
    {
        
        $filters = $request->toDTO();
        $backups = $this->backupService->list($filters);

        $backups->getCollection()->transform(
            fn ($backup) => new BackupResource($backup)
        );

        
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
