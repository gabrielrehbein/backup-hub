<?php

namespace App\Modules\Notifications\Actions;

use App\Modules\Backups\Models\BackupRisk;
use App\Modules\Notifications\Mail\BackupRiskMail;
use Illuminate\Support\Facades\Mail;
use App\Modules\Notifications\Contracts\Strategies\Notifiable;


class NotifyBackupWithRisk implements Notifiable
{
    public function send(mixed $backupRisk){
        $softwareHouseTeamEmail = "gabadev63@gmail.com";
        Mail::to($softwareHouseTeamEmail, "Backup Hub API")->send(new BackupRiskMail(
            $backupRisk,
        ));
    }
}

