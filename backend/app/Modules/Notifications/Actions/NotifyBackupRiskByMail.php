<?php

namespace App\Modules\Notifications\Actions;

use App\Modules\Backups\Models\BackupRisk;
use App\Modules\Notifications\Mail\BackupRiskMail;
use Illuminate\Support\Facades\Mail;
use App\Modules\Notifications\Contracts\Strategies\NotifyMethodStrategy;


class NotifyBackupRiskByMail implements NotifyMethodStrategy
{
    private string $to;
    private BackupRisk $content;

    public function __construct(BackupRisk $backupRisk, string $to) {
        $this->content = $backupRisk;
        $this->to = $to;
    }

    private function sendIsNecessary(): bool
    {
        if (!$this->content instanceof BackupRisk) {
            return false;
        }
        if (!$this->content->is_active) {
            return false;
        }
        if(!$this->content->risk->notifiable) {
            return false;
        }
        return true;
    }


    public function send(){
        if ($this->sendIsNecessary()) {
            Mail::to($this->to, "Backup Hub API")->send(new BackupRiskMail(
                $this->content,
            ));
        }
    }
}
