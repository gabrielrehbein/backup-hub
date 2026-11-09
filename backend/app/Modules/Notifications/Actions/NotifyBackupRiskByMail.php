<?php

namespace App\Modules\Notifications\Actions;

use App\Modules\Backups\Models\BackupRisk;
use App\Modules\Notifications\Mail\BackupRiskMail;
use Illuminate\Support\Facades\Mail;
use App\Modules\Notifications\Contracts\Strategies\NotifyMethodStrategy;
use App\Modules\Notifications\Models\Notification;
use App\Modules\Notifications\Models\NotificationConfig;

class NotifyBackupRiskByMail implements NotifyMethodStrategy
{
    private const TYPE = 'email';
    private const TITLE = 'Risco de Backup';

    private BackupRisk $content;
    private NotificationConfig $config;

    public function __construct(BackupRisk $backupRisk, NotificationConfig $config) {
        $this->content = $backupRisk;
        $this->config = $config;
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
        if (!$this->sendIsNecessary()) {
            return;
        }

        Mail::to($this->config->email, "Backup Hub API")->send(new BackupRiskMail(
            $this->content,
        ));

        $this->saveNotification();
    }

    private function saveNotification(): void
    {
        $backup = $this->content->backup;
        $client = $backup->instances->client;

        Notification::create([
            'type' => self::TYPE,
            'to' => $this->config->email,
            'title' => self::TITLE,
            'content' => sprintf(
                'Risco %s de %s identificado no backup %d do cliente %s. %s',
                $this->content->risk->name,
                $this->content->type === 'time' ? 'tempo' : 'tamanho',
                $backup->id,
                $client->name,
                $this->content->description ?? ''
            ),
            'notification_config_id' => $this->config->id,
            'backup_risk_id' => $this->content->id,
        ]);
    }
}
