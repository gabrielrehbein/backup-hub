<?php

namespace App\Modules\Notifications\Models;


use Illuminate\Database\Eloquent\Model;

class NotificationConfig extends Model
{
    protected $fillable = [
        "email",
    ];

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
