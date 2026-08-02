<?php

namespace App\Modules\Systems\Models;

use Illuminate\Database\Eloquent\Model;

class SystemInstance extends Model
{
    protected $fillable = [
        'system_id',
        'client_id',
        'version',
    ];

    public function system()
    {
        return $this->belongsTo(System::class);
    }
}
