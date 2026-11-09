<?php

namespace App\Modules\Backups\Models;

use App\Modules\Backups\Observers\BackupRiskObserver;
use App\Modules\Risks\Models\Risk;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Modules\Notifications\Models\Notification;

#[ObservedBy(BackupRiskObserver::class)]
class BackupRisk extends Model
{
    /** @use HasFactory<\Database\Factories\BackupErrorFactory> */
    use HasFactory;

    protected $fillable = [
        "backup_id",
        "risk_id",
        "type",
        "is_active",
        "delay_in_minutes",
        "size_loss_percent",
        "description"
    ];

    public function backup(): BelongsTo
    {
        return $this->belongsTo(Backup::class);
    }

    public function risk(): BelongsTo
    {
        return $this->belongsTo(Risk::class);
    }




    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}
