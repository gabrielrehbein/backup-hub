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

    protected $appends = [
        'risk'
    ];

    public function risks(): HasMany
    {
        return $this->hasMany(BackupRisk::class);
    }

    public function instances(): BelongsTo {
        return $this->belongsTo(
            SystemInstance::class,
            'system_instance_id',
            'id'
        );
    }

    public function getRiskAttribute(){
        $risks = $this->risks()
            ->where('is_active', true)
            ->get();

        $riskQuantity = $risks->count();

        if ($riskQuantity === 0) {
            return 0;
        }

        $totalRisksLevel = 0;

        foreach ($risks as $risk) {
            $totalRisksLevel += $risk->riskType->level ?? 0;
        }

        return $totalRisksLevel / $riskQuantity;
    }
    
}
