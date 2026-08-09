<?php

namespace App\Modules\Backups\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Modules\Backups\Models\BackupRisk;
use App\Modules\Systems\Models\SystemInstance;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Backup extends Model
{

    use HasFactory;

    protected $fillable = [
        'file_size_kb',
        'generated_at',
        'is_local',
        'system_instance_id',
        'source_ip',
        'file_path',
        'version'
    ];

    public function risks(): HasMany
    {
        return $this->hasMany(BackupRisk::class);
    }

    public function instances(): BelongsTo {
        return $this->belongsTo(SystemInstance::class);
    }
    
}
