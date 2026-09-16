<?php

namespace App\Modules\Backups\Http\Controllers;

use App\Modules\Backups\Contracts\Services\BackupServiceInterface;
use App\Modules\Backups\DTOs\CreateBackupDTO;
use App\Modules\Backups\DTOs\CreateBackupRiskDTO;
use App\Modules\Backups\Errors\InstanceNotBelongsToClientHttpException;
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
use App\Modules\Notifications\Actions\NotifyBackupRiskByMail;
use App\Modules\Notifications\Services\SendNotificationService;
use App\Modules\Risks\Enums\RiskTypeEnum;
use App\Modules\Systems\Contracts\Services\SystemInstanceServiceInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\UnauthorizedException;

class BackupController extends Controller
{
    public function __construct(
        private readonly BackupServiceInterface $backupService,
        private readonly SystemInstanceServiceInterface $systemInstanceService
    ) {}

    public function testRisk()
    {
        $backupRiskService = new BackupRiskService(
            new BackupRiskEloquentRepository(),
            new BackupEloquentRepository(),
            new SendNotificationService()
        );

        $br = $backupRiskService->create(
            new CreateBackupRiskDTO(
                6,
                3,
                RiskTypeEnum::SIZE,
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
        $createBackupRequestDTO = $request->toDTO();
        $instance = $request->attributes->get('instance');

        $createBackupRequestDTO->systemInstanceId = $instance->id;

        $backup = $this->backupService->create($createBackupRequestDTO);
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

    public function lastBackupsByInstances()
    {
        $backups = $this->backupService->findLastBackupByInstances();
        return JSONResponse::success(
            $backups,
            BuildResponseMessage::findAll(ResourceEnum::BACKUP),
            200
        );
    }

}
