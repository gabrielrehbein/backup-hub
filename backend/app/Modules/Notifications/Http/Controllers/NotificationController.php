<?php

namespace App\Modules\Notifications\Http\Controllers;

use App\Modules\Notifications\Mail\BackupRiskMail;
use App\Modules\Risks\Repositories\RiskEloquentRepository;
use App\Modules\Risks\Services\RiskService;
use App\Shared\Http\Responses\JSONResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationController
{
    public function send(Request $request){

        return JSONResponse::success("Notification sent successfully");
    }
}
