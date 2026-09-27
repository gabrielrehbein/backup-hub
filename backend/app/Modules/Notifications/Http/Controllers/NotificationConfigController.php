<?php

namespace App\Modules\Notifications\Http\Controllers;

use App\Modules\Notifications\Contracts\Services\NotificationConfigServiceInterface;
use App\Modules\Notifications\Http\Requests\StoreNotificationConfigRequest;
use App\Modules\Notifications\Services\NotificationConfigService;
use App\Shared\Http\Responses\JSONResponse;
use Illuminate\Http\Request;



class NotificationConfigController
{
    public function __construct(
        private  NotificationConfigServiceInterface $notificationConfigService,
    ){}

    public function save(StoreNotificationConfigRequest $request){
        $dto = $request->toDTO();
        $notificationConfig = $this->notificationConfigService->save($dto);
        return JSONResponse::success($notificationConfig, "Configuração de notificação salvada com sucesso");
    }
}
