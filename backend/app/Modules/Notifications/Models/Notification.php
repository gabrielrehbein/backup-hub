<?php

namespace App\Modules\Notifications\Models;

use App\Modules\Backups\Models\BackupRisk;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        "type",
        "to",
        "title",
        "content",
        "notification_config_id",
        "backup_risk_id",
    ];

    public function notificationConfig()
    {
        return $this->belongsTo(NotificationConfig::class);
    }

    public function backupRisk()
    {
        return $this->belongsTo(BackupRisk::class);
    }
}
