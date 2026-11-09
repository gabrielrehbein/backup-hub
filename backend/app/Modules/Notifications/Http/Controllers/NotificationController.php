<?php

namespace App\Modules\Notifications\Http\Controllers;

use App\Modules\Notifications\Mail\BackupRiskMail;
use App\Modules\Notifications\Services\NotificationService;
use App\Modules\Risks\Repositories\RiskEloquentRepository;
use App\Modules\Risks\Services\RiskService;
use App\Shared\Http\Responses\JSONResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationController
{
    public function __construct(
        private NotificationService $notificationService
    )
    {
        $this->notificationService = $notificationService;
    }
    public function index(){
        $notifications = $this->notificationService->list();
        return JSONResponse::success($notifications, "Notificações listadas com sucesso.");
    }
}
