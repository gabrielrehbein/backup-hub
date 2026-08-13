<?php

namespace App\Modules\Systems\Models;

use App\Modules\Clients\Models\Client;
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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
