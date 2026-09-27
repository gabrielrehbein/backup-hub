<?php

namespace App\Modules\Notifications\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        "type",
        "title",
        "content",
        "notification_config_id",
    ];

    public function notificationConfig()
    {
        return $this->belongsTo(NotificationConfig::class);
    }
}
