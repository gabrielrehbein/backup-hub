<?php

namespace App\Modules\Clients\Models;

use App\Modules\Risks\Models\Risk;
use Illuminate\Database\Eloquent\Model;


class Plan extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function risks()
    {
        return $this->hasMany(Risk::class);
    }
}
