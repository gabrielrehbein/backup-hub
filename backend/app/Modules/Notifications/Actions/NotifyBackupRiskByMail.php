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
    private NotificationConfig $config;
    private BackupRisk $content;

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
        if ($this->sendIsNecessary()) {
            Mail::to($this->config->email, "Backup Hub API")->send(new BackupRiskMail(
                $this->content,
            ));
            Notification::create([
                'type' => 'email',
                'to' => $this->config->email,
                'title' => 'Risco de Backup',
                'content' => $this->buildContent(),
                'notification_config_id' => $this->config->id,
            ]);
        }
    }

    private function buildContent(): string
    {
        $backup = $this->content->backup;
        $client = $backup->instances->client;

        $riskType = $this->content->type === 'time' ? 'tempo' : 'tamanho';

        return sprintf(
            'Risco %s de %s identificado no backup %d do cliente %s. %s',
            $this->content->risk->name,
            $riskType,
            $backup->id,
            $client->name,
            $this->content->description ?? ''
        );
    }
}
