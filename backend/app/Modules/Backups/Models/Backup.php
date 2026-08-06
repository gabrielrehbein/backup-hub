<?php

namespace App\Modules\Backups\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    
}
